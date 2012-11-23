#!/usr/bin/env python
import time
import sys
import piface.pfio as pfio

def open_evsco_valve():
    pfio.init()
    pfio.digital_write(1,1)
    time.sleep(4)
    pfio.digital_write(1,0)
    


def close_evsco_valve():
    pfio.init()
    pfio.digital_write(0,1)
    time.sleep(4)
    pfio.digital_write(0,0)
