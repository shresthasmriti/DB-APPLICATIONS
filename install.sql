CREATE TABLE Customer
(
  Name VARCHAR(30) NOT NULL,
  CreditCard_Info INT NOT NULL,
  contact_number INT NOT NULL,
  License_number INT NOT NULL,
  Customer_ID INT NOT NULL,
  PRIMARY KEY (Customer_ID),
  UNIQUE (CreditCard_Info),
  UNIQUE (License_number)
);

CREATE TABLE Vehicle
(
  Passenger_capacity INT NOT NULL,
  Registration_plate_ INT NOT NULL,
  fuel_range INT NOT NULL,
  availability INT NOT NULL,
  Customer_ID INT,
  PRIMARY KEY (Registration_plate_),
  FOREIGN KEY (Customer_ID) REFERENCES Customer(Customer_ID)
);

CREATE TABLE Maintenance
(
  MStart_date DATE NOT NULL,
  MFinish_date DATE NOT NULL,
  Registration_plate_ INT NOT NULL,
  FOREIGN KEY (Registration_plate_) REFERENCES Vehicle(Registration_plate_)
);

CREATE TABLE Booking
(
 Booking_ID INT NOT NULL,
 price INT NOT NULL,
 availability INT NOT NULL,
 Registration_plate_ INT NOT NULL,
 Customer_ID INT NOT NULL,
 FOREIGN KEY (Customer_ID) REFERENCES Customer(Customer_ID),
 FOREIGN KEY (Registration_plate_) REFERENCES Vehicle(Registration_plate_)
);

CREATE TABLE Vehicle_insurance
(
  insurance VARCHAR(30) NOT NULL,
  Registration_plate_ INT NOT NULL,
  PRIMARY KEY (insurance, Registration_plate_),
  FOREIGN KEY (Registration_plate_) REFERENCES Vehicle(Registration_plate_)
);

CREATE TABLE Passenger_capacity
(
  vehicle_type VARCHAR(100) NOT NULL,
  Registration_plate_ INT NOT NULL,
  FOREIGN KEY (Registration_plate_) REFERENCES Vehicle(Registration_plate_)
);

INSERT INTO `Customer` VALUES ('Mark', '162517112', '982716162', '172618161', '7865');
INSERT INTO `Customer` VALUES ('John', '415725382', '987167111', '172618999', '2413');
INSERT INTO `Customer` VALUES ('Shrestha', '137181281', '966800563', '128171917', '2348');
INSERT INTO `Customer` VALUES ('True', '172682122', '981726181', '128381715', '2345');
INSERT INTO `Vehicle` VALUES ('10', '1786545', '3000', '5', '2345');
INSERT INTO `Vehicle` VALUES ('32', '12311032', '2500', '3', '2413');
INSERT INTO `Vehicle` VALUES ('20', '12311036', '2500', '3', '2348');
INSERT INTO `Booking` VALUES ('1', '2000', '5', '1786545', '2345');
INSERT INTO `Booking` VALUES ('2', '1500', '3', '12311032', '2413');
INSERT INTO `Booking` VALUES ('3', '1000', '3', '12311036', '2348');
INSERT INTO `Maintenance` VALUES ('2021-06-08', '2021-06-15', '12311036');
INSERT INTO `Maintenance` VALUES ('2021-06-01', '2021-06-06', '12311032');
INSERT INTO `Vehicle_insurance` VALUES ('Yes', '1786545');
INSERT INTO `Vehicle_insurance` VALUES ('No', '12311032');
INSERT INTO `Vehicle_insurance` VALUES ('Yes', '12311036');
INSERT INTO `Passenger_capacity` VALUES ('van', '12311032');



