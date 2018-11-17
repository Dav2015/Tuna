# -*- coding: utf-8 -*-
"""
Created on Sat Nov 17 14:10:14 2018

@author: davidcamara
"""


# Python Program to blur image 
  
# Importing cv2 module 
import cv2  
import os

files = os.listdir("./")

for f in files:
    if f[-3:] == "jpg":
        img = cv2.imread(f) 
        blurImg = cv2.blur(img,(40,40))  
        cv2.imwrite(f,blurImg)  
        