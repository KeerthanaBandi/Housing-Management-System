CREATE DATABASE EliteHMS; -- created a New Database -- Srikeerthana Reddy Bandi (sribandi)
USE EliteHMS;

-- This table contains the entire data from our dataset. This will be used as master table from which other normalized tables are derived
CREATE TABLE Apts (   -- Chandrika Sowmini D (cdevabha)
  ID INT AUTO_INCREMENT PRIMARY KEY,
  PropertyName VARCHAR(255) NOT NULL,
  HouseType VARCHAR(255) NOT NULL,
  Bedrooms INT,
  Bathrooms INT,
  SqFt INT,
  Rent INT,
  Images TEXT,
  Amenities TEXT,
  AdditionalDetails TEXT,
  Address TEXT NOT NULL,
  BalconyOrPatio TEXT,
  Availability TEXT
);

-- Loading data from csv into the table -- Chandrika Sowmini D (cdevabha)
LOAD DATA INFILE '/Users/chandrikad/Desktop/Dataset.csv' INTO TABLE Apts
FIELDS TERMINATED BY ','
OPTIONALLY ENCLOSED BY '"'
LINES TERMINATED BY '\r\n'
IGNORE 1 ROWS; 

SELECT * from EliteHMS.Apts; -- 200 rows returned -- Pavani lakshmi Gunnam (pgunnam)

-- Normolization of Apts Table
-- Eliminating repeating groups in individual tables. 
-- Creating a separate table for each set of related data. 
-- Identifing each set of related data with a primary key.

SELECT DISTINCT (PropertyName) , Address, Amenities from Apts; -- 5 rows returned 

-- Each property has only one address and property name is always Unique -- Chandrika Sowmini D (cdevabha)
CREATE TABLE Property ( 
  PropertyName VARCHAR(255) PRIMARY KEY,
  PropertyAddress VARCHAR(255) NOT NULL,
  Amenities TEXT
);

SELECT DISTINCT(HouseType) Bedrooms, Bathrooms, SqFt, Rent, Images, AdditionalDetails, BalconyOrPatio from Apts;  -- 10 rows returned

-- Each HouseType same Bedrooms, Bathrooms, SqFt, Rent, Images, Additional Details, Address, BalconyOrPatio
CREATE TABLE HouseType ( -- Srikeerthana Reddy Bandi (sribandi)
  HouseType VARCHAR(255) PRIMARY KEY,
  Bedrooms INT,
  Bathrooms INT,
  SqFt INT,
  Rent INT CHECK (Rent>=0),
  Images TEXT,
  AdditionalDetails TEXT,
  BalconyOrPatio TEXT
);

-- Availability table has all the apartments with corresponding availability status -- Pavani lakshmi Gunnam (pgunnam)
CREATE TABLE Availability ( 
  ID INT AUTO_INCREMENT PRIMARY KEY NOT NULL,
  PropertyName VARCHAR(255) NOT NULL,
  HouseType VARCHAR(255) NOT NULL,
  Availability TEXT NOT NULL,
  FOREIGN KEY (PropertyName) REFERENCES Property(PropertyName),
  FOREIGN KEY (HouseType) REFERENCES HouseType(HouseType)
); 

-- This table contains credentials of admins
CREATE TABLE PropertyAdmin (
  AdminId INT PRIMARY KEY,
  AdminName VARCHAR(20),
  Email VARCHAR(50),
  Passkey VARCHAR(60)
);

-- Inserting data from Apts table to Property Table -- Pavani lakshmi Gunnam (pgunnam)
INSERT INTO EliteHMS.Property (PropertyName, PropertyAddress, Amenities)
SELECT PropertyName, Address, Amenities
FROM ( 
SELECT DISTINCT PropertyName, Address, Amenities
    FROM EliteHMS.Apts) as UniqueProperties;
    
SELECT * FROM EliteHMS.Property; -- 5 rows returned 

-- Inserting data from Apts to HouseType Table -- Srikeerthana Reddy Bandi (sribandi)
INSERT INTO EliteHMS.HouseType (HouseType, Bedrooms, Bathrooms, SqFt, Rent, Images, AdditionalDetails, BalconyOrPatio)
SELECT HouseType, Bedrooms, Bathrooms, SqFt, Rent, Images, AdditionalDetails, BalconyOrPatio
FROM ( 
SELECT DISTINCT(HouseType), Bedrooms, Bathrooms, SqFt, Rent, Images, AdditionalDetails, BalconyOrPatio
    FROM EliteHMS.Apts) as UniqueHouseTypes;

SELECT * FROM EliteHMS.HouseType; -- 10 rows retured

-- Inserting data from Apts to Availability Table -- Chandrika Sowmini D (cdevabha)
INSERT INTO EliteHMS.Availability (PropertyName, HouseType, Availability)
SELECT PropertyName, HouseType, Availability
FROM EliteHMS.Apts;

SELECT * FROM EliteHMS.Availability;

-- Since we no longer need the table
TRUNCATE EliteHMS.Apts;

-- Query to get entire data in one table  -- Chandrika Sowmini D (cdevabha)
SELECT  
  Property.PropertyName, 
  Property.PropertyAddress, 
  Property.Amenities, 
  HouseType.HouseType, 
  HouseType.Bedrooms, 
  HouseType.Bathrooms, 
  HouseType.SqFt, 
  HouseType.Rent, 
  HouseType.Images, 
  HouseType.AdditionalDetails, 
  HouseType.BalconyOrPatio, 
  Availability.Availability
FROM 
  Property
  INNER JOIN Availability ON Property.PropertyName = Availability.PropertyName
  INNER JOIN HouseType ON Availability.HouseType = HouseType.HouseType;
  
  -- Created a view to retrive entire information of available house -- Srikeerthana Reddy Bandi (sribandi)
CREATE VIEW AvailableProperties AS
SELECT 
  Property.PropertyName, 
  Property.PropertyAddress, 
  Property.Amenities, 
  HouseType.HouseType, 
  HouseType.Bedrooms, 
  HouseType.Bathrooms, 
  HouseType.SqFt, 
  HouseType.Rent, 
  HouseType.Images, 
  HouseType.AdditionalDetails, 
  HouseType.BalconyOrPatio
FROM 
  Property
  INNER JOIN Availability ON Property.PropertyName = Availability.PropertyName
  INNER JOIN HouseType ON Availability.HouseType = HouseType.HouseType
WHERE 
  Availability.Availability = 'Yes';
  
  SELECT * FROM AvailableProperties;
  
  SELECT * FROM AvailableProperties WHERE Rent < 1500;
