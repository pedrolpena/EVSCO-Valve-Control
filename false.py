#!/usr/bin/env python
import os
import sys
import RPi.GPIO as GPIO


GPIO.setwarnings(False)
GPIO.setmode(GPIO.BCM)
GPIO.setup(int(sys.argv[1]),GPIO.OUT)
GPIO.output(int(sys.argv[1]),False)

