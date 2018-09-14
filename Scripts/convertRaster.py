#!/usr/bin/env python
# -*- coding: utf-8 -*-
"""
@author: Naeem Levy

 

NOTE: Currently only works in POSIX systems
"""

from osgeo import gdal

filepath = "capepoint_risk.tif"

# Open the file:
raster = gdal.Open(filepath)

# Check type of the variable 'raster'
print(type(raster))

# Projection
raster.GetProjection()

# Dimensions
print(raster.RasterXSize)
raster.RasterYSize

# Number of bands
raster.RasterCount

# Metadata for the raster dataset
metadata = raster.GetMetadata()

band = raster.GetRasterBand(1)

print(band)
print(raster.GetGeoTransform())

print(band.GetNoDataValue())

