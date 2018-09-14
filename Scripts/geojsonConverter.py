#!/usr/bin/env python
# -*- coding: utf-8 -*-
"""
@author: Naeem Levy

Converts a csv file to a laeflet compatible geojson file for overlaying on webmap.
To be called as a subprocess.

Ensure that this script has admin prielegeds eg. chmod +x 

NOTE: Currently only works in POSIX systems
"""

import csv
import sys
from geojson import Feature, FeatureCollection, Point, dump

if ( len(sys.argv) <1 ):
    print("Error: no argumant given")
else:
	inputfile = sys.argv[1]
	points = []
	with open(inputfile,'rb') as csvfile:
		reader = csv.reader(csvfile, delimiter=',', quotechar='|')
		i = 0
		for x,y,z in reader:
			if ( i < 10):
				i=i+1
				continue
			else:
				x = float(x)
				y = float(y)
				z  = float(z)
				if ( z < float(0)):
					continue
				else:
					points.append(Feature( geometry = Point((x,y)), properties = {'z': z}))
				i = 0
				print(i)
	print("Coying features")
	feature_collection = FeatureCollection(points, crs="EPSG:3857")
	with open('myfile.geojson', 'w') as f:
		dump(feature_collection, f, indent = 2)
	print("Hello")
