#!/usr/bin/env python
# -*- coding: utf-8 -*-
"""
@author: Naeem Levy

Script function: This script creates a extent-boundry shapefile and outputs the path to a boundry shapefile.

Input, via sys.argv: The boundry shapfile supplied by user.

Output: path to extent boundry

Standard Methods for reading in shapefiles and outputting them used
from the python gdalcookbook

NOTE: Currently only works in POSIX systems
Ensure that this script has admin prielegeds eg. chmod +x 
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
        nest = sys.argv[3]

        infile = toppath+"/Users/"+user+"/temp/"+filename
        #Standard way to read in shp file.
        inDriver = ogr.GetDriverByName("ESRI Shapefile")

        if inDriver is None:
            print("Shapefile is broken or does not exist")
            sys.exit
        else:
            inDataSource = inDriver.Open(infile, 0)
            inLayer = inDataSource.GetLayer()
            numFeatures = inLayer.GetFeatureCount()

            if(numFeatures == None):
                print("flag:False")
                sys.exit
            elif(numFeatures == 0 or numFeatures > 1):
                print("flag:False")
                sys.exit
            else:
                print("flag:True")
                # Calculate extent
                extent = inLayer.GetExtent()
                inDataSource.Destroy()
                rasObject = gr.Raster(user,extent,infile,nest)
                rasObject.filepath()
                inDataSource = None


    except Exception as e:
        print(e)
