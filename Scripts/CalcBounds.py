#!/usr/bin/env python2
# -*- coding: utf-8 -*-
"""
Created on Sat Aug 25 11:45:51 2018

@author: Naeem Levy

Script function: This script creates a extent-boundry shapefile and outputs the path to a boundry shapefile.

Input, via sys.argv: The boundry shapfile supplied by user.

Output: path to extent boundry

Standard Methods for reading in shapefiles and outputting them used
from the python gdalcookbook

NOTE: Implement Error Handling
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
        nest = sys.argv[3]
        
        infile = toppath+"/Users/"+user+"/temp/"+filename
        
        #Standard way to read in shp file.
        inDriver = ogr.GetDriverByName("ESRI Shapefile")
        inDataSource = inDriver.Open(infile, 0)
        inLayer = inDataSource.GetLayer()

        # Calculate extent
        extent = inLayer.GetExtent()
        inDataSource.Destroy()        
        rasObject = gr.Raster(user,extent,infile,nest)
        rasObject.filepath()
        
        
    except Exception as e:
        print(e)
    
