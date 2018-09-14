#!/usr/bin/env python
# -*- coding: utf-8 -*-
"""
@author: Naeem Levy

Checks the number of features in a shaefile and 
reurn an error message if zero or greater than one.

NOTE: Currently only works in POSIX systems
"""

from osgeo import ogr
import sys
import getRasters as gr
import os



if ( len(sys.argv) <1 ):
    #This will have to be handled better
    print("Error: No argument given")
else:
    try:
        toppath = (os.getcwd().rsplit("/",1))[0]

        user = sys.argv[1]
        filename = sys.argv[2]
        

        infile = toppath+"/Users/"+user+"/temp/"+filename
        print(infile)
        #Standard way to read in shp file.
        inDriver = ogr.GetDriverByName("ESRI Shapefile")
        if inDriver is None:
            print("Shapefile is broken or does not exist")
        else:
            inDataSource = inDriver.Open(infile, 0)
            inLayer = inDataSource.GetLayer()

            numFeatures = inLayer.GetFeatureCount()

            if(numFeatures == None):
                print("flag:False")
            else if(numFeatures == 0 || numFeatures > 1):
                print("flag:False")
            else:
                print("flag:True")



    except Exception as e:
        print(e)