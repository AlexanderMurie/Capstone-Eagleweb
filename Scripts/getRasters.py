#!/usr/bin/env python2
# -*- coding: utf-8 -*-
"""
Created on Sat Aug 25 13:10:44 2018

@author: Naeem Levy

Brother do you have some fruitloops??

Programming outputs pathnames of srtm files that intersect with user input boundry shapefile.
"""

#import subprocess as sp
import os
import math as m
import csv
import subprocess

class Raster(object):

    def __init__(self, name, boundry, filename, nest):
        self.userName = name
        self.longMin = boundry[0]
        self.longMax = boundry[1]
        self.latMin = boundry[2]
        self.latMax = boundry[3]
        self.shapefile = filename
        self.nestname = nest

    #Places the point in the correct latitude and longitude SRTM number.
    def corrLong(self,lon):
                
        if(lon<0):            
            lon = m.ceil(lon)
        else:
            lon = m.floor(lon)
            
        return int(lon)
    
    def corrLat(self,lat):
        
        if(lat<0): 
            lat = m.floor(lat)
        else:
            lat = m.ceil(lat)
        
        return int(lat)

    # Builds the Correct Latitude Name ( Conforming to SRTM Naming Conventions ) included
    # for the northern hemisphere even though for completion
    def slat(self,lat):
        if(lat<0):
            lat = abs(lat)
            lat = '{}{:02.0f}'.format('s',lat)
        else:
            lat = '{}{:02.0f}'.format('n',lat)
            
        return lat

    # Builds the Correct Longitube Name ( conforming to SRTM naming conventions ) included
    # for the northern hemisphere even though for completion
    def slong(self,lon):
        if(lon<0):
            lon = abs(lon)
            lon = '{}{:03.0f}'.format('w',lon)
        else:
            lon = '{}{:03.0f}'.format('e',lon)
            
        return lon

    #Constructs filepath names to SRTM .tiff files
    def userpath(self,username):
        ppath = (os.getcwd().rsplit("/",1))[0]
        userpath = ppath+"/Users/"+username
        
        return userpath
    
    #Returns path to SRTM filelocation given lat and long
    def SRTMpath(self,lat,longitude):
        ppath = (os.getcwd().rsplit("/",1))[0]
        SRTM = ppath+"/SRTM/"+lat+"_"+longitude+"_1arc_v3.hgt"
        
        return SRTM
    
    #Returns path to SRTMsd filelocation given lat and long
    def sdpath(self,lat,longitude):
        ppath = (os.getcwd().rsplit("/",1))[0]
        sd = ppath+"/SRTMSD/"+lat+"_"+longitude+"_1arc_v3.tif"
        
        return sd
    
    #Return the path to the output file containing pathnames
    def outfile(self,username,choice):
        if (choice==1):
            ppath = (os.getcwd().rsplit("/",1))[0]
            filename = "{}_{}.csv".format(username,os.getpid())
            path = ppath+"/Users/"+username+"/temp/"+filename  
            return path
        
        elif(choice == 0):
            return "{}_{}.csv".format(username,os.getpid())
        
    #Returns a write csv file.
    def writefile(self,username):
        filepath = self.outfile(username,1)
        csvObj = open(filepath,'wb')
        
        return csvObj


    def filepath(self):
        
        latmin = self.corrLat(self.latMin)
        latmax = self.corrLat(self.latMax)
        longmin = self.corrLong(self.longMin)
        longmax = self.corrLong(self.longMax)
        
        shapepath = self.shapefile
        userpath = self.userpath(self.userName)
        outpath = self.outfile(self.userName,1)
                
        with self.writefile(self.userName) as outfile:
            write = csv.writer(outfile, delimiter=',', quotechar='|', quoting=csv.QUOTE_MINIMAL)
            write.writerow((["Name","Path"]))
            write.writerow((["Nest",userpath+"/temp/"+self.nestname]))
            write.writerow((["Shape",shapepath]))
            
            for i in range(latmin,latmax+1):
                for j in range(longmin,longmax+1):
                    write.writerow((["SRTM",self.SRTMpath(self.slat(i),self.slong(j))]))
                    
            for i in range(latmin,latmax+1):
                for j in range(longmin,longmax+1):
                    write.writerow((["SRTMsd",self.sdpath(self.slat(i),self.slong(j))]))
        
        

if __name__ == "__main__":
    print("Helper class to locate user, shapefile and raster file path to aid in geoprocessing")
    subprocess.call (["ls", "-l"],shell= False)
    print("Use main method for testing Units")

    
    
    
    
    
    
    
    
    
    
    
    # might use later -- subprocess.call("gdalinfo s33_e024_1arc_v3.tif", shell=True)
