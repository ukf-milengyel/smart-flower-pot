# gpio
from gpiozero import MCP3202
import RPi.GPIO as GPIO

# dht sensor
import board
import adafruit_dht
import psutil

# time
from time import sleep
from time import strftime
import datetime

# settings
from os import path
import json

# processes
import os
import sys
import psutil

# db
import sqlite3 as sl

# adc
soil = MCP3202(channel=0)
light = MCP3202(channel=1)

# status leds
leds = [16,20,21,26]
for i in range(len(leds)):
    GPIO.setup(leds[i], GPIO.OUT, initial=GPIO.LOW)

# relay control
relay = 17
button = 27
GPIO.setup(relay, GPIO.OUT, initial=GPIO.LOW)
GPIO.setup(button, GPIO.IN, pull_up_down=GPIO.PUD_UP)

# temp, humidity sensor
for proc in psutil.process_iter():
    if proc.name() == 'libgpiod_pulsein' or proc.name() == 'libgpiod_pulsei':
        proc.kill()
dht11 = adafruit_dht.DHT11(board.D23)

def status_led(s):
    for i in range(4):
        GPIO.output(leds[i], GPIO.LOW)
    if s == -1:
        return
    GPIO.output(leds[s], GPIO.HIGH)
    
def anim_led(s):
    status_led(-1)
    for i in range(5):
        GPIO.output(leds[s], GPIO.HIGH if i%2==0 else GPIO.LOW)
        sleep(0.1)
    
def exit_with_error():
    status_led(-1)
    GPIO.output(relay, GPIO.LOW)
    
    for i in range(20):
        for j in range(2):
            GPIO.output(leds[j], GPIO.HIGH if i%2==0 else GPIO.LOW)
        sleep(0.5)

    GPIO.cleanup()
    exit(1)
    
# create or load config from file
config_file = "config.json"
config = {
        "pump_enable": True,
        "manual_update_enable": True,      # allow button press to manually refresh data
        "update_delay": 60,                # time between data readings
        "pump_threshold": 0.25,            # values lower than this will turn on the pump
        "pump_on_time": 3,                 # how long to run the pump for
        "status_led_threshold": [0.3, 0.4, 0.45, 0.5]   # moisture values for status leds
    }

try:
    if not path.exists(config_file):
        print("config file not found, creating new one")
        json_str = json.dumps(config, indent=4)
    
        f = open(config_file,"w")
        f.write(json_str)
        f.close()
    else:
        f = open(config_file, "r")
        config = json.loads(f.read())
        f.close()
        print("successfully loaded config file")
except:
    print("Error: config file is broken or corrupted")
    exit_with_error()
    
if len(leds) is not len(config["status_led_threshold"]):
    print("Error: length of status_led_threshold should be", len(leds))
    exit_with_error()
    
print(json.dumps(config, indent=4))

# wait for dht11 to start
print("initializing dht11")
while True:
    for i in range(len(leds)):
        status_led(i)
        sleep(0.05)
    for i in range(len(leds)-2,-1,-1):
        status_led(i)
        sleep(0.05)
    
    try:
        t = dht11.temperature
        h = dht11.humidity
        if t is not None and h is not None:
            break
    except RuntimeError as error:
        sleep(0.05)
        continue
    except Exception as error:
        dht11.exit()
        raise error
    
# database
# create tables if db doesn't exist
con = sl.connect('database.db')
con.execute("""
    CREATE TABLE IF NOT EXISTS flower_pot (
        id INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT,
        soil_humidity FLOAT,
        light_level FLOAT,
        temperature TINYINT,
        air_humidity TINYINT,
        update_type TINYINT DEFAULT 0,
        pump TINYINT DEFAULT 0,
        timestamp TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    );
""")
insert_query = 'INSERT INTO flower_pot (soil_humidity, light_level, temperature, air_humidity, update_type, pump, timestamp) VALUES(?,?,?,?,?,?,?)'

# sensor related functions
def process_soil(val):
    led_threshold = config["status_led_threshold"]
    
    for i in range(len(led_threshold)):
        if val <= led_threshold[i]:
            anim_led(i)
            return
    # in case we reach the limit
    anim_led(len(leds)-1)

def process_pump(val, time):
    pump_threshold = config["pump_threshold"]
    if config["pump_threshold"] < val:
        return 0
    pump_on_time = config["pump_on_time"]
    print("soil humidity below {}%, running pump for {} seconds".format(pump_threshold*100,pump_on_time))
    GPIO.output(relay, GPIO.HIGH)
    sleep(pump_on_time)
    GPIO.output(relay, GPIO.LOW)
    return 1

next_check = datetime.datetime.now()
tick = 1
update_types = ["automatic", "button", "web"]

status_led(-1)

try:
    while True:
        now = datetime.datetime.now()
        # skip if next check has not been reached and button isnot pressed
        manual_update = False
        manual_water = False
        button_pressed = not (GPIO.input(button) or not config["manual_update_enable"])

        for process in psutil.process_iter():
            if process.cmdline() == ["python", "manual_update.py"]:
                manual_update = True
            elif process.cmdline() == ["python", "manual_restart.py"]:
                os.execv(sys.executable, ['python'] + sys.argv)
            elif process.cmdline() == ["python", "manual_water.py"]:
                manual_water = True

        if (next_check > now
            and not button_pressed
             and not manual_update):
            sleep(tick)
            continue

        # delay next time check
        next_check = now + datetime.timedelta(seconds = config["update_delay"])

        # get type
        update_type = 2 if manual_update else 1 if button_pressed else 0

        print("-------------------------------------------")
        print("checking sensors, next check at", next_check)
        print("time:  ", now )
        print("type:   {} ({})".format(update_types[update_type], update_type))

        # adc
        s = soil.value
        l = light.value
        print("soil:   {}%".format(s*100))
        print("light:  {}%".format(l*100))

        # temp/humidity sensor
        temp, humidity = None, None
        while True:
            try:
                temp = dht11.temperature
                humidity = dht11.humidity
                if temp is None or humidity is None:
                    sleep(0.05)
                    continue
                print("temp:   {}*C\nhumid:  {}% ".format(temp, humidity))
                break
            except RuntimeError as error:
                print("dht11 error:",error.args[0])
                sleep(0.05)
                continue
            except Exception as error:
                dht11.exit()
                raise error

        # process soil humidity
        pump_on = 0
        process_soil(s)
        if config["pump_enable"]:
            pump_on = process_pump(0 if manual_water else s, now)

        # save to database
        data = [ (s, l, temp, humidity, update_type, pump_on, now) ]
        con.executemany(insert_query, data)
        con.commit()

        sleep(0.2)
except Exception as e:
    print("Program terminated:",e)
    exit_with_error()
finally:
    GPIO.cleanup()