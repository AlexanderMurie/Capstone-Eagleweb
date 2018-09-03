# VERA: Verreaux's Eagle Risk Analysis
# Megan Murgatroyd

#Steven Theron
#Notes
# 'require' is used inside functions, as it outputs a warning and continues if the package is not found, whereas library will throw an error.  https://stackoverflow.com/questions/5595512/what-is-the-difference-between-require-and-library
# The '<-' is the "assignment operator", giving something a name. '=' also works but is frowned upon.
# 'merge' docs --> https://www.rdocumentation.org/packages/raster/versions/2.6-7/topics/merge

#SET YOUR WORKING DIRECTORY
#setwd("c:/Users/PFPUser/Desktop/CompSci")

#packages you need to install to run (you only need to do this step the first time):
#install.packages("effects")   #CANT INSTALL THIS PACKAGE ON THE SNR LAB PC'S VERSION OF RSTUDIO.
#install.packages("lme4")
#install.packages("rgdal")
#install.packages("raster")
#install.packages("geosphere")

      # #This bit you don't need, it is for my own record of what I have given you (.
        # require(lme4)
        # scaled_data_risk2=scaled_data_risk[sample(nrow(scaled_data_risk), 5000),]
        # all_mod = glmer(bin~nest_dist*slope+asp4+slope_sd3+alt+(1|name), data=scaled_data_risk2, family=binomial, na.action = "na.fail")
        # saveRDS(all_mod, "riskmod.rds")

#Load the above model and look at the effects:
#variables in the model are: nest_dist = the distance from the nest
#                           slope = terrain slop
#                           slope_sd = the standard deviation of the slope in a grid around each GPS fix
#                           alt = terrain altitude (elevation)

#The code block below requires the "effects" package.
require(effects)
riskmod <- readRDS("riskmod.rds")
#this allows you to see the effects of each variable, it's not important at the stage as this is not the final model 
#but it does include all of the relevant variables that I expect will feature in the final model.
plot(allEffects(riskmod), type="response")
#End of block

##### WEBSITE SIMULATION: CAPE POINT#####
require(rgdal)
require(raster)

#Scenario: A developer is interested in putting a wind farm on the Cape Penninsula, there is one Verreaux's eagle nest on site:
#This is the development area as a shapefile:
#NB: you should be able to enter any shapfile/coordinates here and that links to the next step to souce the DEMs, 
# consider inventing a development in the Karoo... as I have invented this one.

dev=readOGR("./User/Bob/temp")  #e.g. dsn = ".", layer = "penninsula")
#dsn is the data source name, i,e, the folder directory. So "." represents the current folder directory.

#load 30m SRTM DEMS: 1 Arc-second (you will need to souces these online somehow for other developement areas)
srtm30a<-raster("./SRTM/s34_e018_1arc_v3.tif")
srtm30b<-raster("./SRTM/s35_e018_1arc_v3.tif")

#merge the two together:
dem=merge(srtm30a, srtm30b) #Digital Elevation Map? stores the merged raster
rm(srtm30a, srtm30b)  #remove the objects

#********visualise this:**********
plot(dem) #plots the digital elevation map using the merged raster.
plot(dev, add=TRUE)  #plots the 'dev' aka development boundary on top of the 'dem' plot.
#I replaced 'T' with 'TRUE' since 'T' can be redefined. See https://stackoverflow.com/questions/6789055/r-inconsistency-why-add-t-sometimes-works-and-sometimes-not-in-the-plot-funct

#output plot to a file
dev.off() #writes plot to a pdf file.

#**********Extract the info needed for the model:**********
#example - terrain(x, opt, unit, neighbors)   #https://www.rdocumentation.org/packages/raster/versions/2.6-7/topics/terrain
slope <-terrain(dem, opt=c('slope'), unit='degrees', neighbors=8) # 8 neighbor cells (queen case) to compute slope for any cell.
aspect <-terrain(dem, opt=c('aspect'), unit='degrees')

#****** LONG PROCESS INCOMING *******
slope_sd3=focal(slope, w=matrix(1,3,3), fun=sd) ##NB this layer take 5min+ to make. It is taking each grid cell and finding the standard deviation of the altitude of it and the cells around it on a 3x3 grid (i.e. SD of 9 cells)

#make a terrain.stack of these layers:
terrain.stack_pen<-stack(list(slope=slope,  aspect=aspect, slope_sd3=slope_sd3, alt=dem)) 

#Crop the terrain.stack by the development boundaries:
crs(dev)=crs(dem)
dem_dev <- crop(terrain.stack_pen, extent(dev), snap='out')
rar <- mask(dem_dev, dev)

#**********convert the raster to points, and convert these points to a dataframe:**********
print("converting raster to points, and the points to a dataframe...")                 #TRACER
rarToP <- rasterToPoints(rar, byid=TRUE, id=rar$nests)
rm(rar)
dev.terrain <- as.data.frame(rarToP)

print(head(dev.terrain)) #displays the first 6 rows of the dataframe as a default.
print("conversion complete.")                 #TRACER

#**********change x y column names:**********
print("changing column names to longitude and latitude...")   #TRACER
names(dev.terrain)[names(dev.terrain) == "x"] <- "longitude"
names(dev.terrain)[names(dev.terrain) == "y"] <- "latitude"

print(head(dev.terrain)) #displays the first 6 rows of the dataframe as a default.
print("column names changed.")                 #TRACER

#add distance to nes: dist_nest:
#The developer needs to provide the nest coordinates, here I input them:
#consider choosing a random area in the Karoo, select any cliff and simulate a Verreaux's eagle nest there and one more 3-5 km away on another cliff

#**********read CSV into R **********
print("Handling nest coordinatess from a CSV file...")   #TRACER
nestCoords <- read.csv(file="./User/Bob/temp/nest_locations.csv", header=TRUE, strip.white=TRUE, sep=",")

is.data.frame(nestCoords) #checks nestCoords is in a data frame format

#add nest lat & long coordinates from the given CSV file.
dev.terrain$nest_lat <- nestCoords$Latitudes
dev.terrain$nest_long <- nestCoords$Longitudes
print(head(dev.terrain))

print("nest coordinatess added to DB.")   #TRACER

#**********calculate the distance between the nest and each grid cell (now each row in the dataframe):**********
print("Calculating and storing the distance between nests...")   #TRACER
require(geosphere)

#splitting the dev boundary and nest locations based on their 'long' and 'lats' into dataframes.
df=data.frame(long=dev.terrain$longitude, lat=dev.terrain$latitude)   #df for dev boundary.
df2=data.frame(long=dev.terrain$nest_long, lat=dev.terrain$nest_lat)  #df for nest coords.

d=distGeo(df, df2) #distGeo is used to accurately estimate the shortest distance between two points on an ellipsoid.
                   #values for distGeo are "Vectors of distances in meters".
d=as.data.frame(d) #stores distance data, in meters, as a data frame.
print(head(d))

#convert to km and add to dataframe:
dev.terrain$nest_dist=d$d/1000 #adds a new coloumn to the dev.terrain dataset.
print(head(dev.terrain))
print("nests stored.")   #TRACER

#**********add categorical aspect to dataframe:**********
print("adding category aspect to dataframe...")   #TRACER
dev.terrain$asp4<-
  ifelse((dev.terrain$aspect <= 45 | dev.terrain$aspect >= 315), "N",
         ifelse((dev.terrain$aspect >= 45 & dev.terrain$aspect < 125), "E",
                ifelse((dev.terrain$aspect >= 125 & dev.terrain$aspect < 225), "S",
                       ifelse((dev.terrain$aspect >= 225 & dev.terrain$aspect < 315), "W", "NA"))))
dev.terrain$asp4=as.factor(dev.terrain$asp4)
print("category aspect added.")   #TRACER

#**********Data frame in now ready to run the model over:**********
print("running model prediction...")   #TRACER
pred <- predict(riskmod, dev.terrain, re.form = NA, type = "response", na.action = na.fail)
pred = as.data.frame(pred)

#you now have probablities 0 -1 which need plotting / converting to tiff / raster:
print(summary(pred$pred))
print("model predicted.")   #TRACER

#**********RISK PLOT:**********
print("plotting risk map...")   #TRACER
toplot=cbind.data.frame(long= dev.terrain$longitude, lat=dev.terrain$latitude, pred=pred$pred) #collision map file.

plottop = subset.data.frame(toplot, toplot$pred > 0.2) #Thabo's line. Cropped out the terrain with pred less than 0.2.
print(head(toplot))
risk_plot=rasterFromXYZ(plottop) #changed toplot to plottop to plot the cropped collision map.

colours=c("darkseagreen1","darkorange","red")
plot(risk_plot, col=colours)
plot(dev, add=T)
print("risk map plotted")   #TRACER
writeRaster(risk_plot, "capepoint_risk", format = "GTiff")

