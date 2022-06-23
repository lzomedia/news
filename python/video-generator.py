import pyttsx3

import sys


text = sys.argv[1:][0]

print(text)

engine = pyttsx3.init()

engine.save_to_file(text , 'test.mp3')

engine.runAndWait()
