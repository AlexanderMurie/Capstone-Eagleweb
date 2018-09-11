# VERA: Verreaux's Eagle Risk Analysis
# Original coder: Megan Murgatroyd

# Modified by Steven Theron

# SET YOUR WORKING DIRECTORY
#setwd("c:/Users/PFPUser/Desktop/CompSci")

#Global variables
#Consider removing some global variables and replacing them with local variables.
username <- ""
userDataFile <- ""
shapeFileName <- ""

dem <- "digitalElevationMap"
dev <- "boundaryMap"
dev.terrain <- ""

riskmod <- ""
slope <- ""
aspect <- ""
slope_sd3 <- ""
rar <- ""

#file paths
nestFilePath <- ""  #/User/Bob/temp/nest_locations.csv
# shapeFilePath <- "" #/User/Bob/temp
focalFilePath <- "" #./Focal

#create a list of srtm variables to store each srtm file path
srtmFileList <- list()
focalFileList <- list()

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

# This code block below requires the "effects" package.
# It reads Megan's given riskmod.rds file and stores its reference and assigns it to a global variable.
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

# Load the rgdal package but continue execution if the package fails to load.
# Read shape files and stores them as a spatial vector object called 'dev'. 
# Assign 'dev' to replace the global variable named 'dev'
readGeoFiles <- function()
{
  #Require packages
  require(rgdal)
  print("rgdal loaded") #TRACER
    
  print("reading shape files ...") #TRACER
  
  #join the home directory to the shape File Path variable.
  # fShapeFilePath = paste(".", shapeFilePath, sep = "")
  # dev = readOGR(fShapeFilePath)  #e.g. dsn = ".", layer (name) = "penninsula")
  fShapeFileName = paste(".", shapeFileName, sep = "")
  dev = readOGR(fShapeFileName) #read shape files with the shapefilename in the current directory.
  
  #dsn is the data source name, i,e, the folder directory. So "." represents the current folder directory.
  assign("dev", dev, envir = .GlobalEnv)
  print("shape files read")                #TRACER
  
  #load 30m SRTM DEMS: 1 Arc-second 
  print("created srtm rasters")            #TRACER
  
  #merge the two together:
  print("begin srtm file merge")
  dem = do.call(merge, srtmFileList) #METHOD PROBLEM: the 'slope', 'aspect' and 'slope_sd3' values are NA.
  #dem = merge(srtm30a, srtm30b) #Digital Elevation Map? stores the merged raster
  
  assign("dem", dem, envir = .GlobalEnv)
  print("srtm files merged.")               #TRACER
  
  #Cleanup
  rm(srtmFileList)  #remove the list to clear up memory
}

# Visualise the digital elevation map with the development boundaries overlayed by plotting the map.
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

# Extract the info needed for the model from the digital elevation map reference and the focal file list.
# Then update the global variables values with those inside this method.
extractData <- function()
{
  print("extracting data...")   #TRACER
  #example - terrain(x, opt, unit, neighbors)   #https://www.rdocumentation.org/packages/raster/versions/2.6-7/topics/terrain
  slope <-terrain(dem, opt=c('slope'), unit='degrees', neighbors=8) # 8 neighbor cells (queen case) to compute slope for any cell.
  aspect <-terrain(dem, opt=c('aspect'), unit='degrees')
  
  #****** LONG PROCESS INCOMING *******
  #slope_sd3 <-focal(slope, w=matrix(1,3,3), fun=sd) ##NB this layer take 5min+ to make. It is taking each grid cell and finding the standard deviation of the altitude of it and the cells around it on a 3x3 grid (i.e. SD of 9 cells)
  slope_sd3 <- do.call(merge, focalFileList)
  print("data extracted")   #TRACER
  
  #make local variables global
  print("assigning local variables...") #TRACER
  assign("slope", slope, envir = .GlobalEnv)
  assign("aspect", aspect, envir = .GlobalEnv)
  assign("slope_sd3", slope_sd3, envir = .GlobalEnv)
  print("assignment complete.") #TRACER
}

# make a terrain.stack of the slope, aspect and slope_sd3 variables.
# crop the terrain.stack by the development boundaries 'dev'.
# create a mask from the development boundary and the terrain stack named 'rar'.
# update the global variable 'rar'.
handleTerrainStack <- function()
{
  print("handling terrain stack...")   #TRACER
  #make a terrain.stack of these layers:
  terrain.stack_pen <-stack(list(slope=slope,  aspect=aspect, slope_sd3=slope_sd3, alt=dem)) 
  
  #Crop the terrain.stack by the development boundaries:
  crs(dev) = crs(dem)
  dem_dev <- crop(terrain.stack_pen, extent(dev), snap='out')
  rar <- mask(dem_dev, dev)
  
  print("printing rar...")
  #print(rar)
  
  assign("rar", rar, envir = .GlobalEnv)
  print("terrain stack complete.")
}

# convert the raster to points, and convert these points to a dataframe
# update the global variable 'dev.terrain'.
convertToDataframe <- function() 
{
  print("converting raster to points, and the points to a dataframe...")                 #TRACER
  rarToP <- rasterToPoints(rar, byid=TRUE, id=rar$nests)
  #rm(rar) #cleanup
  
  dev.terrain <- as.data.frame(rarToP)
  
  print(head(dev.terrain)) #displays the first 6 rows of the dataframe as a default.
  print("conversion complete.")                 #TRACER
  
  assign("dev.terrain", dev.terrain, envir = .GlobalEnv)
}

# change the 'x' and 'y' column names to 'longitude' and 'latitude' respectively.
# update the global variable 'dev.terrain' to reflect the column name changes.
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

# Read nest coordinates stored in a .csv file from a file path.
# Update the dev.terrain table with nest latitude and longitude coordinates.
# Calculate the distance between the nest and each grid cell (now each row in the dataframe):
# Update the dev.terrain table to reflect the a new column called 'nest_dist'.
handleNestCoordsCSV <- function() 
{
  print("Handling nest coordinatess from a CSV file...")   #TRACER
  #read CSV into R
  
  #join the home directory to the srtm File Path variable.
  nestFilePathFull = paste(".", nestFilePath, sep = "")
  nestCoords <- read.csv(file = nestFilePathFull, header = TRUE, strip.white = TRUE, sep = ",")

  print("Calculating and storing the distance between nests...")   #TRACER
  require(geosphere)
  # splitting the dev boundary and nest locations based on their 'long' and 'lats' into dataframes.
  df = data.frame(long=dev.terrain$longitude, lat=dev.terrain$latitude)   #df for dev boundary.
  
  #add nest lat & long coordinates from the given CSV file.
  nestCounter <- 1
  df_n <- ""
  dist_n <- ""
  
  for (nest in nestCoords$Latitudes)
  {
    # join the nest_lat or nest_long heading with the nest number.
    nest_lat <- paste0("nest_lat", nestCounter)
    nest_long <- paste0("nest_long", nestCounter)
    
    # CREATING COLUMN NAMES AND POPULATING THEIR COLUMNS WITH NEST LATS & LONGS.
    dev.terrain$nest_lat <- nestCoords$Latitudes[nestCounter]
    dev.terrain$nest_long <- nestCoords$Longitudes[nestCounter]
    
    # create distance dataframes(dfs) for each nest coordinate.
    df_n <- paste0("df", nestCounter)
    df_n = data.frame(long = dev.terrain$nest_long, lat = dev.terrain$nest_lat)
    # print("printing df_n")
    # print(head(df_n))  #TRACER
  
    # COMPARE DF BOUNDARY DISTANCE with NEST DISTANCE
    dist_n <- paste0("dist_n", nestCounter)
    dist_n <- distGeo(df, df_n) # distGeo is used to accurately estimate the shortest distance between two points on an ellipsoid.
                                # values for distGeo are "Vectors of distances in meters".
    dist_n = as.data.frame(dist_n) #stores the distances in distance data, in meters, as a data frame.
    
    # print("printing dist_n")
    # print(head(dist_n))  #TRACER
    
    # print("changing column names for nest long & lat...")   #TRACER
    # change x y column names:
    names(dev.terrain)[names(dev.terrain) == "nest_lat"] <- nest_lat
    names(dev.terrain)[names(dev.terrain) == "nest_long"] <- nest_long
    # print("column names for nest long & lat changed.")                 #TRACER
    
    # CREATING NEW COLUMN NAMED 'nest_dist_temp'
    dev.terrain$nest_dist_new = dist_n$dist_n/1000  #convert to km and add to dataframe:
    
    # COMPARE NEST DISTANCE VALUES
    # compare the old nest val with the new nest val &
    # store the min nest distance in a new column named 'nest_dist'. 
    if (nestCounter > 1)  #there is an old nest dist value so...
    {
      dev.terrain$nest_dist = with (dev.terrain, pmin(nest_dist_old, nest_dist_new))
    }
    
    # print("Printing dev.terrain before nest_dist_old is updated")
    # print(head(dev.terrain)) #TRACER
    dev.terrain$nest_dist_old <- dev.terrain$nest_dist_new # set the new nest distance to become the old nest distance.
    
    # print("Printing dev.terrain at end of for-loop") #TRACER
    # print(head(dev.terrain)) #TRACER
    nestCounter <- nestCounter + 1
  }

  assign("dev.terrain", dev.terrain, envir = .GlobalEnv) #UPDATE global var 'dev.terrain'
  print("nest coordinatess added to DB.")   #TRACER
}

# Add categorical aspect to dataframe:
# Update the dev.terrain table to reflect a new column called 'asp4.
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

# Run the model to predict the collision map using the dev.terrain dataframe and the riskmod.
# Call the plotRiskMap method and pass it the 'pred' dataframe reference.
runModel <- function() 
{
  print("running model prediction...")   #TRACER
  pred <- predict(riskmod, dev.terrain, re.form = NA, type = "response") #REMOVED na.action = na.fail
  pred = as.data.frame(pred)
  
  #you now have probablities 0 -1 which need plotting / converting to tiff / raster:
  print(summary(pred$pred))
  print("model predicted.")   #TRACER
  
  plotRiskMap(pred)
}

# plot the risk map with color and write it to a csv file called 'capepoint_risk'.
plotRiskMap <- function(pred)
{
  print("plotting risk map...")   #TRACER
  toplot=cbind.data.frame(long= dev.terrain$longitude, lat=dev.terrain$latitude, pred=pred$pred) #collision map file.
  
  plottop = subset.data.frame(toplot, toplot$pred > 0.2) #Thabo's line. Cropped out the terrain with pred less than 0.2.
  print(head(plottop))
  
  risk_plot=rasterFromXYZ(plottop) #changed toplot to plottop to plot the cropped collision map.
  
  colours=c("darkseagreen1","darkorange","red")
  plot(risk_plot, col=colours)
  plot(dev, add=T)
  
  print("risk map plotted")   #TRACER
  writeRaster(risk_plot, "capepoint_risk", format = "GTiff", overwrite = TRUE) #Print out a Gtiff of the risk-map.
}

# load the raster package. 
# read the user data csv file and store the file paths for the nest data, the shape files,
# the srtm files and the focal files associated with the srtm files.
# update the global values for the relevant lists and file paths.
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
      convertSRTMFP <- as.character(srtmFilePath) #srtmFilePath is a factor. Convert to a character
      testSplit <- strsplit(convertSRTMFP, split = "/", fixed = TRUE) #strsplit does not work on factors.
      
      #get srtm file name with extension
      srtmFilewExtension <- tail(testSplit[[1]],1) #for a single string, '[[' converts the 'list' to a 'vector' and gets the last element with 'tail']]
      
      #only get the srtm file name
      getSRTMFileName<- strsplit(srtmFilewExtension, ".", fixed = TRUE)
      
      #add .tif to the srtm file name --> creating the focal file name.
      focalFile <- paste0(head(getSRTMFileName[[1]],1), ".tif")
      focalFilePath <- paste("./Focal/", focalFile, sep = "")
      
      #add raster of new srtm file path to the srtm file list postion of (row counter - 2).
      srtmFileList[[myRowCounter-2]] <- raster(nsrtmFilePath)
      focalFileList[[myRowCounter-2]] <- raster(focalFilePath)
    }
  }
  
  #assign global variables (x), to equal the local variables value.
  assign("nestFilePath", nestFilePath, envir = .GlobalEnv)
  assign("shapeFilePath", shapeFilePath, envir = .GlobalEnv)
  assign("srtmFileList", srtmFileList, envir = .GlobalEnv)
  assign("focalFileList", focalFileList, envir = .GlobalEnv)
  
  print("Finished reading user CSV file.") #TRACER
}

# Start the program and accept two parameters from Naeem's Python script.
# Accept username and the name of the user's data file.
# then call the methods inside this program in a sequential and logical order.
main <- function()
{
  args <- commandArgs(trailingOnly = TRUE)
  
  if (!is.na(args[1]) && !is.na(args[2])) print("sufficient input")
  {
    #Read via Naeem's Python program.
    print("reading user input ...") #TRACER
    assign("username", args[1], envir = .GlobalEnv)
    assign("shapeFileName", args[2], envir = .GlobalEnv) #set the shpFileLayerName variable to equal args[2].
    assign("userDataFile", args[3], envir = .GlobalEnv) #set the filenameCSV variable to equal args[1].
  }

  #Tracer statements
  cat(username, sep = "\n")   #TRACER
  cat(shapeFileName, sep = "\n")   #TRACER
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
  addCat()
  runModel()
  
  print("R program finished!")   #TRACER
}

main()
