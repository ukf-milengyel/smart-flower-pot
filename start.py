import psutil
import os

for process in psutil.process_iter():
        if process.cmdline() == ["python", "main.py"]:
            process.kill()
            
os.system("python main.py")