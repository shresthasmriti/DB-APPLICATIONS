The purpose of the database is to manage and keep track of customer information, vehicle reservation, booking, and confirmation.

This database is to keep track of customer’s information that includes what vehicle they rented, name, address, phone number, date hired, credit card information, passport number, license number, etc.  
And Vehicle rental service have a record of the customers and the vehicles they rent. And according to the vehicle type and number of days they rent it for, determines the prices for rental. 
A vehicle rental service must have a record to display booking availability and reservation confirmations along with vehicle type. 

About this course-
Database Applications is a continuation of Database Concepts. We learned to design database from Concepts and now we are developing it into a complete computer application with documentation. 


Installation:
1. Install MAMP.
2. Start MAMP which will display a window. Click start. 
3. After you start it will direct you to MAMP website. Click on phpMyAdmin.
4. Click on the databases tab and add your script. My Database script is:

CREATE TABLE Customer
(
  Name INT NOT NULL,
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
  MStart_date INT NOT NULL,
  MFinish_date INT NOT NULL,
  Registration_plate_ INT NOT NULL,
  FOREIGN KEY (Registration_plate_) REFERENCES Vehicle(Registration_plate_)
);

CREATE TABLE Vehicle_insurance
(
  insurance INT NOT NULL,
  Registration_plate_ INT NOT NULL,
  PRIMARY KEY (insurance, Registration_plate_),
  FOREIGN KEY (Registration_plate_) REFERENCES Vehicle(Registration_plate_)
);

CREATE TABLE Passenger_capacity
(
  vehicle_type INT NOT NULL,
  Registration_plate_ INT NOT NULL,
  FOREIGN KEY (Registration_plate_) REFERENCES Vehicle(Registration_plate_)
);

5) If you added tables to your database, you will now see a + next to the database name, denoting there are tables in the databse. Click on that to open the database and see the tables. Then click on a table and the Structure tab to see the table structure view.

Next you add values-

INSERT INTO `Customer` (`Name`, `CreditCard_Info`, `contact_number`, `License_number`, `Customer_ID`) VALUES ('Mark ', '16251711', '098271616', '172618161', '7865');
INSERT INTO `Maintenance` (`MStart_date`, `MFinish_date`, `Registration_plate_`) VALUES ('2021-06-08', '2021-06-15', '12311036');!
INSERT INTO `Passenger_capacity` (`vehicle_type`, `Registration_plate_`) VALUES ('van', '12311032');
INSERT INTO `Vehicle` (`Passenger_capacity`, `Registration_plate_`, `fuel_range`, `availability`, `Customer_ID`) VALUES ('32', '12311032', '2500', '3', '2413');
INSERT INTO `Vehicle_insurance` (`insurance`, `Registration_plate_`) VALUES ('No', '12311032');


In order to communicate with the database:
1) The code must be saved in htdocs which is under MAMP application.
2) and after you save it type in http://localhost:8888/ 
 

