# VERA: Verreaux's Eagle Risk Analysis
# Megan Murgatroyd

#Steven Theron
#Notes
# 'require' is used inside functions, as it outputs a warning and continues if the package is not found, whereas library will throw an error.  https://stackoverflow.com/questions/5595512/what-is-the-difference-between-require-and-library
# The '<-' is the "assignment operator", giving something a name. '=' also works but is frowned upon.
# to get help for a method type '?' before the function. I.e. '?hist'
# Enter 'CRTL+SHIFT+C' to comment out sections of code.
# https://www.tutorialspoint.com/r/r_json_files.htm

#SET YOUR WORKING DIRECTORY
#setwd("c:/Users/PFPUser/Desktop/CompSci")

#Global variables
#Consider removing some global variables and replacing them with local variables.
username <- "user"
userDataFile <- "user data"
dem <- "digitalElevationMap"
dev <- "boundaryMap"
dev.terrain <- ""

riskmod <- ""
slope <- ""
aspect <- ""
slope_sd3 <- ""
rar <- ""

#file paths
nestFilePath <- "" #/User/Bob/temp/nest_locations.csv
shapeFilePath <- "" #/User/Bob/temp

#create a list of srtm variables to store each srtm file path
srtmFileList <- list()

#packages you need to install to run (you only need to do this step the first time):
installPacks <- function() 
{
  install.packages("effects")   #CANT INSTALL THIS PACKAGE ON THE SNR LAB PC'S VERSION OF RSTUDIO.
  install.packages("lme4")
  install.packages("rgdal")
  install.packages("raster")
  install.packages("geosphere")
}

#Load the above model and look at the effects:
#variables in the model are: nest_dist = the distance from the nest
#                           slope = terrain slop
#                           slope_sd = the standard deviation of the slope in a grid around each GPS fix
#                           alt = terrain altitude (elevation)

#Read a Json file
readJsonFile <- function()
{
  #library(rjson) #Doesnt work.
  #try: https://stackoverflow.com/questions/2617600/importing-data-from-a-json-file-into-r
  #library(RJSONIO)
  #library(RCurl)
  #jsonData <- fromJSON(file="filename.json")   #READ dat from a JSON file.
}

#The code block below requires the "effects" package.
plotEffects <- function() 
{
  print("ploting effects") #TRACER
  require(effects)
  riskmod <- readRDS("riskmod.rds")
  
  #this allows you to see the effects of each variable, it's not important at the stage as this is not the final model 
  #but it does include all of the relevant variables that I expect will feature in the final model.
  
  #plot(allEffects(riskmod), type="response")     #HALTING EXECUTION
  
  assign("riskmod", riskmod, envir = .GlobalEnv)
  print("effects plotted.") #TRACER
}

##### WEBSITE SIMULATION: CAPE POINT#####
readGeoFiles <- function()
{
  #Require packages
  require(rgdal)
  print("rgdal loaded") #TRACER
    
  #Scenario: A developer is interested in putting a wind farm on the Cape Penninsula, there is one Verreaux's eagle nest on site:
  #This is the development area as a shapefile:
  #NB: you should be able to enter any shapfile/coordinates here and that links to the next step to souce the DEMs, 
  # consider inventing a development in the Karoo... as I have invented this one.
  
  print("reading shape files ...") #TRACER
  
  #join the home directory to the shape File Path variable.
  fShapeFilePath = paste(".", shapeFilePath, sep = "")
  dev = readOGR(fShapeFilePath)  #e.g. dsn = ".", layer (name) = "penninsula")
  
  #dsn is the data source name, i,e, the folder directory. So "." represents the current folder directory.
  
  assign("dev", dev, envir = .GlobalEnv)
  print("shape files read")                #TRACER
  
  #load 30m SRTM DEMS: 1 Arc-second (you will need to souces these online somehow for other developement areas)
  #srtm30a <-raster("./SRTM/s34_e018_1arc_v3.tif")
  #srtm30b <-raster("./SRTM/s35_e018_1arc_v3.tif")
  print("created srtm rasters")            #TRACER
  
  #merge the two together:
  print("begin srtm file merge")
  dem = do.call(merge, srtmFileList) #METHOD PROBLEM: the 'slope', 'aspect' and 'slope_sd3' values are NA.
  #dem = merge(srtm30a, srtm30b) #Digital Elevation Map? stores the merged raster
  
  assign("dem", dem, envir = .GlobalEnv)
  print("srtm files merged.")               #TRACER
  
  #Cleanup
  #rm(srtm30a, srtm30b)  #remove the objects
  #rm(srtmFileList)  #remove the list to clear up memory
}

visualisePlots <- function()
{
  print("Plotting DEM & DEV...")                 #TRACER
  #visualise this:
  plot(dem) #plots the digital elevation map using the merged raster.
  plot(dev, add=TRUE)  #plots the 'dev' aka development boundary on top of the 'dem' plot.
  #I replaced 'T' with 'TRUE' since 'T' can be redefined. See https://stackoverflow.com/questions/6789055/r-inconsistency-why-add-t-sometimes-works-and-sometimes-not-in-the-plot-funct
  
  #output plot to a file
  dev.off() #writes plot to a pdf file.
  
  print("DEM & DEV plotted.")                 #TRACER
}

#Extract the info needed for the model:
extractData <- function()
{
  print("extracting data...")   #TRACER
  #example - terrain(x, opt, unit, neighbors)   #https://www.rdocumentation.org/packages/raster/versions/2.6-7/topics/terrain
  slope <-terrain(dem, opt=c('slope'), unit='degrees', neighbors=8) # 8 neighbor cells (queen case) to compute slope for any cell.
  aspect <-terrain(dem, opt=c('aspect'), unit='degrees')
  
  #****** LONG PROCESS INCOMING *******
  slope_sd3 <-focal(slope, w=matrix(1,3,3), fun=sd) ##NB this layer take 5min+ to make. It is taking each grid cell and finding the standard deviation of the altitude of it and the cells around it on a 3x3 grid (i.e. SD of 9 cells)
  print("data extracted")   #TRACER
  
  #make local variables global
  print("assigning local variables...") #TRACER
  assign("slope", slope, envir = .GlobalEnv)
  assign("aspect", aspect, envir = .GlobalEnv)
  assign("slope_sd3", slope_sd3, envir = .GlobalEnv)
  print("assignment complete.") #TRACER
  
  #handleTerrainStack(slope, aspect, slope_sd3)
}

handleTerrainStack <- function()
{
  print("handling terrain stack...")   #TRACER
  #make a terrain.stack of these layers:
  terrain.stack_pen <-stack(list(slope=slope,  aspect=aspect, slope_sd3=slope_sd3, alt=dem)) 
  
  # print("print aspect...")
  # print(aspect)
  # print("print slope")
  # print(slope)
  # print("print slope_sd3")
  # print(slope_sd3)
  
  #Crop the terrain.stack by the development boundaries:
  crs(dev) = crs(dem)
  dem_dev <- crop(terrain.stack_pen, extent(dev), snap='out')
  rar <- mask(dem_dev, dev)
  
  print("printing rar...")
  print(rar)
  
  assign("rar", rar, envir = .GlobalEnv)
  
  print("terrain stack complete.")
  #convertToDataframe(rar)
}

#convert the raster to points, and convert these points to a dataframe:
convertToDataframe <- function() 
{
  print("converting raster to points, and the points to a dataframe...")                 #TRACER
  rarToP <- rasterToPoints(rar, byid=TRUE, id=rar$nests)
  #rm(rar) #cleanup
  
  dev.terrain <- as.data.frame(rarToP)
  
  #assign("dev.terrain", dev.terrain , envir = .GlobalEnv) #overwrite the global variable 
  print(head(dev.terrain)) #displays the first 6 rows of the dataframe as a default.
  print("conversion complete.")                 #TRACER
  
  #TESTING
  assign("dev.terrain", dev.terrain, envir = .GlobalEnv)
  #changeColNames(dev.terrain)   #TRACER
}

changeColNames <- function()
{
  print("changing column names to longitude and latitude...")   #TRACER
  #change x y column names:
  names(dev.terrain)[names(dev.terrain) == "x"] <- "longitude"
  names(dev.terrain)[names(dev.terrain) == "y"] <- "latitude"
  print(head(dev.terrain)) #displays the first 6 rows of the dataframe as a default.
  
  assign("dev.terrain", dev.terrain, envir = .GlobalEnv) #UPDATE global var 'dev.terrain'
  print("column names changed.")                 #TRACER
}

#add distance to nes: dist_nest:
#The developer needs to provide the nest coordinates, here I input them:
#consider choosing a random area in the Karoo, select any cliff and simulate a Verreaux's eagle nest there and one more 3-5 km away on another cliff

handleNestCoordsCSV <- function() 
{
  print("Handling nest coordinatess from a CSV file...")   #TRACER
  #read CSV into R
  
  #join the home directory to the srtm File Path variable.
  nestFilePathh = paste(".", nestFilePath, sep = "")
  nestCoords <- read.csv(file = nestFilePathh, header = TRUE, strip.white = TRUE, sep = ",")

  is.data.frame(nestCoords) #checks nestCoords is in a data frame format
  print(nestCoords$Latitudes) #TRACER
  
      #read.csv reads the specified file into a data frame that creates a variable called 'myData.nestLocations'.
      #header=TRUE specifies that this data includes a header row and sep=”,” specifies that the data is separated by commas 
      #(though read.csv implies the same I think it’s safer to be explicit).
      #Source: http://rprogramming.net/read-csv-in-r/
      #'strip.white' removes spaces that were inserted before the data values in the CSV file.
  
  #add nest lat & long coordinates from the given CSV file.
  dev.terrain$nest_lat <- nestCoords$Latitudes
  dev.terrain$nest_long <- nestCoords$Longitudes
  print(head(dev.terrain)) #TRACER
  
  assign("dev.terrain", dev.terrain, envir = .GlobalEnv) #UPDATE global var 'dev.terrain'
  print("nest coordinatess added to DB.")   #TRACER
}

#calculate the distance between the nest and each grid cell (now each row in the dataframe):
calcDist <- function()
{
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
  
  assign("dev.terrain", dev.terrain, envir = .GlobalEnv) #UPDATE global var 'dev.terrain'
  print("nests stored.")   #TRACER
}

#add categorical aspect to dataframe:
addCat <- function()
{
  print("adding category aspect to dataframe...")   #TRACER
  dev.terrain$asp4<-
    ifelse((dev.terrain$aspect <= 45 | dev.terrain$aspect >= 315), "N",
           ifelse((dev.terrain$aspect >= 45 & dev.terrain$aspect < 125), "E",
                  ifelse((dev.terrain$aspect >= 125 & dev.terrain$aspect < 225), "S",
                         ifelse((dev.terrain$aspect >= 225 & dev.terrain$aspect < 315), "W", "NA"))))
  dev.terrain$asp4=as.factor(dev.terrain$asp4)
  
  assign("dev.terrain", dev.terrain, envir = .GlobalEnv) #UPDATE global var 'dev.terrain'
  print("category aspect added.")   #TRACER
}

#Data frame in now ready to run the model over:
runModel <- function() 
{
  print("running model prediction...")   #TRACER
  pred <- predict(riskmod, dev.terrain, re.form = NA, type = "response", na.action = na.fail)
  pred = as.data.frame(pred)
  
  #you now have probablities 0 -1 which need plotting / converting to tiff / raster:
  print(summary(pred$pred))
  print("model predicted.")   #TRACER
  
  plotRiskMap(pred)
}

#RISK PLOT:
plotRiskMap <- function(pred)
{
  print("plotting risk map...")   #TRACER
  toplot=cbind.data.frame(long= dev.terrain$longitude, lat=dev.terrain$latitude, pred=pred$pred) #collision map file.
  
  plottop = subset.data.frame(toplot, toplot$pred > 0.2) #Thabo's line. Cropped out the terrain with pred less than 0.2.
  print(head(toplot))
  risk_plot=rasterFromXYZ(toplot) #changed toplot to plottop to plot the cropped collision map.
  
  colours=c("darkseagreen1","darkorange","red")
  plot(risk_plot, col=colours)
  plot(dev, add=T)
  
  print("risk map plotted")   #TRACER
  writeRaster(risk_plot, "capepoint_risk", format = "GTiff")
}

readUserCSVFile <- function() #Read via CSV
{
  print("reading user CSV file ...") #TRACER
  
  require(raster)
  print("raster loaded") #TRACER
  
  #store nestFileName
  #get nest file path from the userInput.csv file.
  userInput <- read.csv(file = "userData.csv", header = TRUE, sep = ",") #The file has a name header and a path header.
  
  #find row length
  rowLength <- length(userInput$Name)
  #print(rowLength, sep="\n")   #TRACER
  
  #create a row counter to track the row items.
  myRowCounter <- 0
  
  for (rowItem in userInput$Name) # iterate for each row item in the first column called "Name"
  {
    myRowCounter <- myRowCounter+1 #increment the row counter by 1 for each iteration of the for-loop.
    
    if (rowItem == "nest")
    {
      nestFilePath <- userInput$Path[myRowCounter] #row 1 will always store the nest tag
      print(nestFilePath, max.levels = 0) #max.levels = 0  means it won't indicate how many levels should be printed for each factor.
    }
    else if (rowItem == "shape")
    {
      shapeFilePath <- userInput$Path[myRowCounter] #row 2 will always store the shape tag
      print(shapeFilePath, max.levels = 0) #TRACER
    }
    else if (rowItem == "srtm")
    {
      srtmFilePath <- userInput$Path[myRowCounter] #rowLength - 2 will always store the srtm tags
      print(srtmFilePath, max.levels = 0)  #TRACER
      
      #join the home directory to the srtm File Path variable.
      nsrtmFilePath = paste(".", srtmFilePath, sep = "")
      
      #add raster of new srtm file path to the srtm file list postion of (row counter - 2).
      srtmFileList[[myRowCounter-2]] <- raster(nsrtmFilePath)
    }
  }

  print("Printing srtm file list")
  for (i in srtmFileList)
  {
    print(i)
  }
  
  #assign global variables (x), to equal the local variables value.
  assign("nestFilePath", nestFilePath, envir = .GlobalEnv)
  assign("shapeFilePath", shapeFilePath, envir = .GlobalEnv)
  assign("srtmFileList", srtmFileList, envir = .GlobalEnv)
  
  print("Finished reading user CSV file.") #TRACER
}

main <- function()
{
  args <- commandArgs(trailingOnly = TRUE)
  
  if (!is.na(args[1]) && !is.na(args[2])) print("sufficient input")
  {
    #Read via TERMINAL
    #assign("filenameCSV", args[1], envir = .GlobalEnv) #set the filenameCSV variable to equal args[1].
    #assign("shpFileLayerName", args[2], envir = .GlobalEnv) #set the shpFileLayerName variable to equal args[2].
    
    #Read via Naeem's Python program.
    print("reading user input ...") #TRACER
    assign("username", args[1], envir = .GlobalEnv)
    assign("userDataFile", args[2], envir = .GlobalEnv)
    
    #HARDCODED ARGS FOR TESTING
    #assign("username", "Bob", envir = .GlobalEnv)
    #assign("userDataFile", "userData.csv", envir = .GlobalEnv)
  }

  #Tracer statements
  cat(username, sep = "\n")   #TRACER
  cat(userDataFile, sep = "\n")   #TRACER
  
  #Begin the method train!
  readUserCSVFile() 
  plotEffects()  #this method is causing trouble.
  readGeoFiles()
  visualisePlots()
  
  extractData()   #LONG PROCESS!!!
  handleTerrainStack()
  convertToDataframe()

  changeColNames()
  handleNestCoordsCSV()
  calcDist()
  addCat()
  runModel()
  
  print("R program finished!")   #TRACER
}

main()
