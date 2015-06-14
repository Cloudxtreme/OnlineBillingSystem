PRAGMA foreign_keys = ON;

DROP TABLE IF EXISTS DocumentTotals;
DROP TABLE IF EXISTS Line;
DROP TABLE IF EXISTS Fatura;
DROP TABLE IF EXISTS Produto;
DROP TABLE IF EXISTS Utilizadores;
DROP TABLE IF EXISTS Cliente;
DROP TABLE IF EXISTS TipoCliente;
DROP TABLE IF EXISTS BillingAddress;
DROP TABLE IF EXISTS Tax;



CREATE TABLE Tax(
ID INTEGER PRIMARY KEY AUTOINCREMENT,
TaxType VARCHAR2(10),
TaxPercentage FLOAT
);


CREATE TABLE BillingAddress(
ID INTEGER PRIMARY KEY AUTOINCREMENT,
AddressDetail VARCHAR2(60),
City VARCHAR2(20),
PostalCode1 INT(4) CHECK (LENGTH(PostalCode1) == 4), 
PostalCode2 INT(3) CHECK (LENGTH(PostalCode2) == 3), 
Country VARCHAR2(20)
);


CREATE TABLE Cliente(
CustomerID INT PRIMARY KEY,
CustomerTaxID INT,
CompanyName VARCHAR2(40),
BillingAddressID INT REFERENCES BillingAddress(ID),
Email VARCHAR2(40)
);

CREATE TABLE Utilizadores(
UserID INTEGER PRIMARY KEY AUTOINCREMENT,
Email VARCHAR2(40),
Username VARCHAR2(20) UNIQUE,
Password VARCHAR2(20),
TipoUtilizadore INT CHECK (TipoUtilizadore==1 OR TipoUtilizadore==2 OR TipoUtilizadore==3) /* 1-> Administrador, 2-> Leitor, 3->Editor */
);


CREATE TABLE Produto(
ProductCode INT PRIMARY KEY,
ProductDescription VARCHAR2(100),
UnitPrice FLOAT,
UnitOfMeasure VARCHAR2(10)
);


CREATE TABLE Fatura(
ID INTEGER PRIMARY KEY AUTOINCREMENT,
InvoiceNo VARCHAR2,
InvoiceDate DATE,
CustomerID INT REFERENCES Cliente(CustomerID)
);


CREATE TABLE Line(
ID INTEGER PRIMARY KEY AUTOINCREMENT,
LineNumber INT CHECK (LineNumber >= 1),
ProductCode REFERENCES Produto(ProductCode),
Quantity INT,
UnitPrice FLOAT,
CreditAmount FLOAT,
TaxID REFERENCES Tax(ID),
FaturaIDL INT REFERENCES Fatura(ID)
);


CREATE TABLE DocumentTotals(
ID INTEGER PRIMARY KEY AUTOINCREMENT,
TaxPayable FLOAT,
NetTotal FLOAT,
GrossTotal FLOAT,
FaturaID INT REFERENCES Fatura(ID)
);


/*---------------------------- TRIGGERS -------------------------------------*/


/*---triggers entrega intermedia---*/

CREATE TRIGGER update_UnitPrice AFTER INSERT ON Line
BEGIN
  UPDATE Line 
  SET UnitPrice = (SELECT UnitPrice FROM Produto WHERE Line.ProductCode = Produto.ProductCode);
END;

CREATE TRIGGER update_UnitPrice2 AFTER UPDATE ON Line
BEGIN
  UPDATE Line 
  SET UnitPrice = (SELECT UnitPrice FROM Produto WHERE Line.ProductCode = Produto.ProductCode);
END;


CREATE TRIGGER update_CreditAmount AFTER INSERT ON Line
BEGIN
  UPDATE Line SET CreditAmount = Quantity*UnitPrice;
END;

CREATE TRIGGER update_CreditAmount2 AFTER UPDATE ON Line
BEGIN
  UPDATE Line SET CreditAmount = Quantity*UnitPrice;
END;


CREATE TRIGGER update_TaxPayable AFTER INSERT ON DocumentTotals
BEGIN
  UPDATE DocumentTotals 
  SET TaxPayable =(SELECT SUM(CreditAmount*TaxPercentage/100)
				   FROM Line, Tax 
				   WHERE Line.FaturaIDL = DocumentTotals.FaturaID
				   AND Line.TaxID = Tax.ID);
END;

CREATE TRIGGER update_TaxPayable2 AFTER UPDATE ON Line
BEGIN
  UPDATE DocumentTotals 
  SET TaxPayable =(SELECT SUM(CreditAmount*TaxPercentage/100)
				   FROM Line, Tax 
				   WHERE Line.FaturaIDL = DocumentTotals.FaturaID
				   AND Line.TaxID = Tax.ID);
END;


CREATE TRIGGER update_NetTotal AFTER INSERT ON DocumentTotals
BEGIN
  UPDATE DocumentTotals 
  SET NetTotal = (SELECT SUM(CreditAmount) FROM Line WHERE Line.FaturaIDL = DocumentTotals.FaturaID);
END;

CREATE TRIGGER update_NetTotal2 AFTER UPDATE ON Line
BEGIN
  UPDATE DocumentTotals 
  SET NetTotal = (SELECT SUM(CreditAmount) FROM Line WHERE Line.FaturaIDL = DocumentTotals.FaturaID);
END;


CREATE TRIGGER update_GrossTotal AFTER INSERT ON DocumentTotals
BEGIN
  UPDATE DocumentTotals SET GrossTotal = TaxPayable + NetTotal;
END;


CREATE TRIGGER update_GrossTotal2 AFTER UPDATE ON Line
BEGIN
  UPDATE DocumentTotals SET GrossTotal = TaxPayable + NetTotal;
END;



/*------------------------------------ INSERTS ---------------------------------------------------------------*/
INSERT INTO Tax(TaxType, TaxPercentage) VALUES ('IVA', 6.00);
INSERT INTO Tax(TaxType, TaxPercentage) VALUES ('IVA', 13.00);
INSERT INTO Tax(TaxType, TaxPercentage) VALUES ('IVA', 23.00);


INSERT INTO BillingAddress(AddressDetail, City, PostalCode1, PostalCode2, Country) VALUES ('Rua Silva, N  1, 1 Andar', 'Porto', 4001, 111, 'Portugal');
INSERT INTO BillingAddress(AddressDetail, City, PostalCode1, PostalCode2, Country) VALUES ('Rua Botto, N 2, 2 Andar', 'Porto', 4002, 222, 'Portugal');
INSERT INTO BillingAddress(AddressDetail, City, PostalCode1, PostalCode2, Country) VALUES ('Rua Taveira, N 3, 3 Andar', 'Porto', 4003, 333, 'Portugal');
INSERT INTO BillingAddress(AddressDetail, City, PostalCode1, PostalCode2, Country) VALUES ('Av Silva, N4, 4 Andar', 'Lisboa', 1001, 444, 'Portugal');
INSERT INTO BillingAddress(AddressDetail, City, PostalCode1, PostalCode2, Country) VALUES ('Rua Gilvaia, N5, 5 Andar', 'Lisboa', 1002, 555, 'Portugal');
INSERT INTO BillingAddress(AddressDetail, City, PostalCode1, PostalCode2, Country) VALUES ('Rua Oliveira, N6, 6 Andar', 'Lisboa', 1003, 666, 'Portugal');
INSERT INTO BillingAddress(AddressDetail, City, PostalCode1, PostalCode2, Country) VALUES ('Pc Vieira, N7, 7 Andar', 'Faro', 5001, 777, 'Portugal');
INSERT INTO BillingAddress(AddressDetail, City, PostalCode1, PostalCode2, Country) VALUES ('Rua Faria, N8, 8 Andar', 'Faro', 5002, 888, 'Portugal');
INSERT INTO BillingAddress(AddressDetail, City, PostalCode1, PostalCode2, Country) VALUES ('Pc Silva, N9, 9 Andar', 'Marco de Canaveses', 6001, 999, 'Portugal');
INSERT INTO BillingAddress(AddressDetail, City, PostalCode1, PostalCode2, Country) VALUES ('Rua Castro, N10, 10 Andar', 'Marco de Canaveses', 6002, 101, 'Portugal');



INSERT INTO Cliente VALUES (1, 11111, 'Diana Silva', 1, 'ds@gmail.com');
INSERT INTO Cliente VALUES (2, 22222, 'Rui Botto', 2, 'rb@gmail.com');
INSERT INTO Cliente VALUES (3, 33333, 'Jose Taveira', 3, 'jt@gmail.com');
INSERT INTO Cliente VALUES (4, 44444, 'Ines Silva', 4, 'is@gmail.com');
INSERT INTO Cliente VALUES (5, 55555, 'Hugo Gilvaia', 5, 'hg@gmail.com');
INSERT INTO Cliente VALUES (6, 66666, 'Rita Oliveira', 6, 'ro@gmail.com');
INSERT INTO Cliente VALUES (7, 77777, 'Ana Vieira', 7, 'av@gmail.com');
INSERT INTO Cliente VALUES (8, 88888, 'Pedro Faria', 8, 'pf@gmail.com');
INSERT INTO Cliente VALUES (9, 99999, 'Osvaldo Silva', 9, 'os@gmail.com');
INSERT INTO Cliente VALUES (10, 10101, 'Ruben Castro', 10, 'rc@gmail.com');


INSERT INTO Utilizadores(Email, Username, Password, TipoUtilizadore) VALUES ('dsu@gmail.com','diana_silva', 'dianasilva1', 1);
INSERT INTO Utilizadores(Email, Username, Password, TipoUtilizadore) VALUES ('rbu@gmail.com','rui_botto', '123456', 2);
INSERT INTO Utilizadores(Email, Username, Password, TipoUtilizadore) VALUES ('jtu@gmail.com','jose_taveira', 'josetaveira3', 3);
INSERT INTO Utilizadores(Email, Username, Password, TipoUtilizadore) VALUES ('isu@gmail.com','ines_silva', 'inessilva4', 2);
INSERT INTO Utilizadores(Email, Username, Password, TipoUtilizadore) VALUES ('hgu@gmail.com','hugo_gilvaia', 'hugogilvaia5', 3);
INSERT INTO Utilizadores(Email, Username, Password, TipoUtilizadore) VALUES ('rou@gmail.com','rita_oliveira', 'ritaoliveira6', 2);
INSERT INTO Utilizadores(Email, Username, Password, TipoUtilizadore) VALUES ('avu@gmail.com','ana_vieira', 'anavieira7', 3);



INSERT INTO Produto VALUES (1, 'Xarope', 1.5, 'Mg');
INSERT INTO Produto VALUES (2, 'Comprimido via oral', 2, 'Mg');
INSERT INTO Produto VALUES (3, 'Almoco', 13.5, 'Unit');
INSERT INTO Produto VALUES (4, 'Jantar', 15.5, 'Unit');
INSERT INTO Produto VALUES (5, 'Caneta', 0.5, 'Unit');
INSERT INTO Produto VALUES (6, 'Computador', 100, 'Unit');
INSERT INTO Produto VALUES (7, 'Caderno', 3, 'Unit');
INSERT INTO Produto VALUES (8, 'Rebucado', 0.5, 'Unit');
INSERT INTO Produto VALUES (9, 'Azeite', 1, 'L');
INSERT INTO Produto VALUES (10, 'Vinho', 2.5, 'L');



INSERT INTO Fatura(InvoiceNo, InvoiceDate, CustomerID) VALUES ('FT SEQ/1', '2013-03-13', 1);
INSERT INTO Fatura(InvoiceNo, InvoiceDate, CustomerID) VALUES ('FT SEQ/2', '2013-04-14', 2);
INSERT INTO Fatura(InvoiceNo, InvoiceDate, CustomerID) VALUES ('FT SEQ/3', '2013-05-15', 3);
INSERT INTO Fatura(InvoiceNo, InvoiceDate, CustomerID) VALUES ('FT SEQ/4', '2013-06-16', 4);
INSERT INTO Fatura(InvoiceNo, InvoiceDate, CustomerID) VALUES ('FT SEQ/5', '2013-07-17', 5);
INSERT INTO Fatura(InvoiceNo, InvoiceDate, CustomerID) VALUES ('FT SEQ/6 ','2013-08-18', 6);
INSERT INTO Fatura(InvoiceNo, InvoiceDate, CustomerID) VALUES ('FT SEQ/7', '2013-09-19', 7);
INSERT INTO Fatura(InvoiceNo, InvoiceDate, CustomerID) VALUES ('FT SEQ/8', '2013-10-20', 8);
INSERT INTO Fatura(InvoiceNo, InvoiceDate, CustomerID) VALUES ('FT SEQ/9', '2013-11-21', 9);
INSERT INTO Fatura(InvoiceNo, InvoiceDate, CustomerID) VALUES ('FT SEQ/10', '2013-12-22', 10);




INSERT INTO Line(LineNumber, ProductCode, Quantity, UnitPrice, CreditAmount, TaxID, FaturaIDL) VALUES (2, 2, 2, 0.0, 0.0, 2, 2);
INSERT INTO Line(LineNumber, ProductCode, Quantity, UnitPrice, CreditAmount, TaxID, FaturaIDL) VALUES (3, 3, 3, 0.0, 0.0, 3, 3);
INSERT INTO Line(LineNumber, ProductCode, Quantity, UnitPrice, CreditAmount, TaxID, FaturaIDL) VALUES (4, 4, 4, 0.0, 0.0, 1, 4);
INSERT INTO Line(LineNumber, ProductCode, Quantity, UnitPrice, CreditAmount, TaxID, FaturaIDL) VALUES (5, 5, 5, 0.0, 0.0, 1, 5);
INSERT INTO Line(LineNumber, ProductCode, Quantity, UnitPrice, CreditAmount, TaxID, FaturaIDL) VALUES (6, 6, 6, 0.0, 0.0, 2, 6);
INSERT INTO Line(LineNumber, ProductCode, Quantity, UnitPrice, CreditAmount, TaxID, FaturaIDL) VALUES (7, 7, 7, 0.0, 0.0, 3, 7);
INSERT INTO Line(LineNumber, ProductCode, Quantity, UnitPrice, CreditAmount, TaxID, FaturaIDL) VALUES (8, 8, 8, 0.0, 0.0, 3, 8);
INSERT INTO Line(LineNumber, ProductCode, Quantity, UnitPrice, CreditAmount, TaxID, FaturaIDL) VALUES (9, 9, 9, 0.0, 0.0, 1, 9);
INSERT INTO Line(LineNumber, ProductCode, Quantity, UnitPrice, CreditAmount, TaxID, FaturaIDL) VALUES (10, 10, 10, 0.0, 0.0, 1, 10);

/*----Para fatura com 2 páginas-------*/
INSERT INTO Line(LineNumber, ProductCode, Quantity, UnitPrice, CreditAmount, TaxID, FaturaIDL) VALUES (1, 1, 1, 0.0, 0.0, 3, 1);
INSERT INTO Line(LineNumber, ProductCode, Quantity, UnitPrice, CreditAmount, TaxID, FaturaIDL) VALUES (2, 2, 3, 0.0, 0.0, 1, 1);
INSERT INTO Line(LineNumber, ProductCode, Quantity, UnitPrice, CreditAmount, TaxID, FaturaIDL) VALUES (3, 3, 4, 0.0, 0.0, 1, 1);
INSERT INTO Line(LineNumber, ProductCode, Quantity, UnitPrice, CreditAmount, TaxID, FaturaIDL) VALUES (4, 4, 1, 0.0, 0.0, 1, 1);
INSERT INTO Line(LineNumber, ProductCode, Quantity, UnitPrice, CreditAmount, TaxID, FaturaIDL) VALUES (5, 5, 2, 0.0, 0.0, 2, 1);
INSERT INTO Line(LineNumber, ProductCode, Quantity, UnitPrice, CreditAmount, TaxID, FaturaIDL) VALUES (6, 6, 3, 0.0, 0.0, 3, 1);
INSERT INTO Line(LineNumber, ProductCode, Quantity, UnitPrice, CreditAmount, TaxID, FaturaIDL) VALUES (7, 7, 4, 0.0, 0.0, 2, 1);
INSERT INTO Line(LineNumber, ProductCode, Quantity, UnitPrice, CreditAmount, TaxID, FaturaIDL) VALUES (8, 8, 5, 0.0, 0.0, 3, 1);


INSERT INTO DocumentTotals(TaxPayable, NetTotal, GrossTotal, FaturaID) VALUES (0.0,0.0,0.0,1);
INSERT INTO DocumentTotals(TaxPayable, NetTotal, GrossTotal, FaturaID) VALUES (0.0,0.0,0.0,2);
INSERT INTO DocumentTotals(TaxPayable, NetTotal, GrossTotal, FaturaID) VALUES (0.0,0.0,0.0,3);
INSERT INTO DocumentTotals(TaxPayable, NetTotal, GrossTotal, FaturaID) VALUES (0.0,0.0,0.0,4);
INSERT INTO DocumentTotals(TaxPayable, NetTotal, GrossTotal, FaturaID) VALUES (0.0,0.0,0.0,5);
INSERT INTO DocumentTotals(TaxPayable, NetTotal, GrossTotal, FaturaID) VALUES (0.0,0.0,0.0,6);
INSERT INTO DocumentTotals(TaxPayable, NetTotal, GrossTotal, FaturaID) VALUES (0.0,0.0,0.0,7);
INSERT INTO DocumentTotals(TaxPayable, NetTotal, GrossTotal, FaturaID) VALUES (0.0,0.0,0.0,8);
INSERT INTO DocumentTotals(TaxPayable, NetTotal, GrossTotal, FaturaID) VALUES (0.0,0.0,0.0,9);
INSERT INTO DocumentTotals(TaxPayable, NetTotal, GrossTotal, FaturaID) VALUES (0.0,0.0,0.0,10);



/*---------------------------- TRIGGERS 2-------------------------------------*/

/*___________triggers updates__________*/

/*Tax*/
CREATE TRIGGER update_TaxType INSERT ON Tax
BEGIN
  UPDATE Tax SET TaxType = NEW.TaxType WHERE Tax.ID = old.ID;
END;

CREATE TRIGGER update_TaxPercentage INSERT ON Tax
BEGIN
  UPDATE Tax SET TaxPercentage = NEW.TaxPercentage WHERE Tax.ID = old.ID;
END;

/*BillingAddress*/
CREATE TRIGGER update_AddressDetail INSERT ON BillingAddress
BEGIN
  UPDATE BillingAddress SET AddressDetail = NEW.AddressDetail WHERE BillingAddress.ID = old.ID;
END;

CREATE TRIGGER update_City INSERT ON BillingAddress
BEGIN
  UPDATE BillingAddress SET City = NEW.City WHERE BillingAddress.ID = old.ID;
END;

CREATE TRIGGER update_PostalCode1 INSERT ON BillingAddress
BEGIN
  UPDATE BillingAddress SET PostalCode1 = NEW.PostalCode1 WHERE BillingAddress.ID = old.ID;
END;

CREATE TRIGGER update_PostalCode2 INSERT ON BillingAddress
BEGIN
  UPDATE BillingAddress SET PostalCode2 = NEW.PostalCode2 WHERE BillingAddress.ID = old.ID;
END;

CREATE TRIGGER update_Country INSERT ON BillingAddress
BEGIN
  UPDATE BillingAddress SET Country = NEW.Country WHERE BillingAddress.ID = old.ID;
END;


/*Cliente*/
CREATE TRIGGER update_CustomerTaxID INSERT ON Cliente
BEGIN
  UPDATE Cliente SET CustomerTaxID = NEW.CustomerTaxID WHERE Cliente.CustomerID = old.CustomerID;
END;

CREATE TRIGGER update_CompanyName INSERT ON Cliente
BEGIN
  UPDATE Cliente SET CompanyName = NEW.CompanyName WHERE Cliente.CustomerID = old.CustomerID;
END;

CREATE TRIGGER update_BillingAddressID INSERT ON Cliente
BEGIN
  UPDATE Cliente SET BillingAddressID = NEW.BillingAddressID WHERE Cliente.CustomerID = old.CustomerID;
END;

CREATE TRIGGER update_Email INSERT ON Cliente
BEGIN
  UPDATE Cliente SET Email = NEW.Email WHERE Cliente.CustomerID = old.CustomerID;
END;


/*Utilizadores*/
CREATE TRIGGER update_EmailUtilizadores INSERT ON Utilizadores
BEGIN
  UPDATE Utilizadores SET Email = NEW.Email WHERE Utilizadores.ID = old.ID;
END;

CREATE TRIGGER update_Username  INSERT ON Utilizadores
BEGIN
  UPDATE Utilizadores SET Username  = NEW.Username  WHERE Utilizadores.ID = old.ID;
END;

CREATE TRIGGER update_Password  INSERT ON Utilizadores
BEGIN
  UPDATE Utilizadores SET Password  = NEW.Password  WHERE Utilizadores.ID = old.ID;
END;

CREATE TRIGGER update_TipoUtilizadores INSERT ON Utilizadores
BEGIN
  UPDATE Utilizadores SET TipoUtilizadore = NEW.TipoUtilizadore WHERE Utilizadores.ID = old.ID;
END;


/*Produto*/
CREATE TRIGGER update_ProductDescription INSERT ON Produto
BEGIN
  UPDATE Produto SET ProductDescription = NEW.ProductDescription WHERE Produto.ProductCode = old.ProductCode;
END;

CREATE TRIGGER update_UnitPrice_Produto INSERT ON Produto
BEGIN
  UPDATE Produto SET UnitPrice = NEW.UnitPrice WHERE Produto.ProductCode = old.ProductCode;
END;

CREATE TRIGGER update_UnitOfMeasure INSERT ON Produto
BEGIN
  UPDATE Produto SET UnitOfMeasure = NEW.UnitOfMeasure WHERE Produto.ProductCode = old.ProductCode;
END;


/*Fatura*/
CREATE TRIGGER update_InvoiceNo INSERT ON Fatura
BEGIN
  UPDATE Fatura SET InvoiceNo = NEW.InvoiceNo WHERE Fatura.ID = old.ID;
END;

CREATE TRIGGER update_InvoiceDate INSERT ON Fatura
BEGIN
  UPDATE Fatura SET InvoiceDate = NEW.InvoiceDate WHERE Fatura.ID = old.ID;
END;

CREATE TRIGGER update_CustomerID INSERT ON Fatura
BEGIN
  UPDATE Fatura SET CustomerID = NEW.CustomerID WHERE Fatura.ID = old.ID;
END;



/*Line*/
CREATE TRIGGER update_LineNumber INSERT ON Line
BEGIN
  UPDATE Line SET LineNumber = NEW.LineNumber WHERE Line.ID = old.ID;
END;

CREATE TRIGGER update_ProductCode INSERT ON Line
BEGIN
  UPDATE Line SET ProductCode = NEW.ProductCode WHERE Line.ID = old.ID;
END;

CREATE TRIGGER update_Quantity INSERT ON Line
BEGIN
  UPDATE Line SET Quantity = NEW.Quantity WHERE Line.ID = old.ID;
END;

CREATE TRIGGER update_TaxID INSERT ON Line
BEGIN
  UPDATE Line SET TaxID = NEW.TaxID WHERE Line.ID = old.ID;
END;

CREATE TRIGGER update_FaturaIDL INSERT ON Line
BEGIN
  UPDATE Line SET FaturaIDL = NEW.FaturaIDL WHERE Line.ID = old.ID;
END;


/*DocumentTotals*/
CREATE TRIGGER update_FaturaID INSERT ON DocumentTotals
BEGIN
  UPDATE DocumentTotals SET FaturaID = NEW.FaturaID WHERE DocumentTotals.ID = old.ID;
END;


/*_______________________________triggers inserts____________________________________________*/


CREATE TRIGGER insert_Tax AFTER INSERT ON Tax
BEGIN
  INSERT INTO Tax(TaxType, TaxPercentage) VALUES (NEW.TaxType, NEW.TaxPercentage);
END;

CREATE TRIGGER insert_BillingAddress AFTER INSERT ON BillingAddress
BEGIN
 INSERT INTO BillingAddress(AddressDetail, City, PostalCode1, PostalCode2, Country) VALUES (NEW.AddressDetail, NEW.City, NEW.PostalCode1, NEW.PostalCode2, NEW.Country);
END;

CREATE TRIGGER insert_Cliente AFTER INSERT ON Cliente
BEGIN
 INSERT INTO Cliente VALUES (NEW.CustomerID, NEW.CustomerTaxID, NEW.CompanyName, NEW.BillingAddressID, NEW.Email);
END;

CREATE TRIGGER insert_Utilizadores AFTER INSERT ON Utilizadores
BEGIN
 INSERT INTO Utilizadores VALUES (NEW.Email, NEW.Username, NEW.Password, NEW.TipoUtilizadore);
END;

CREATE TRIGGER insert_Produto AFTER INSERT ON Produto
BEGIN
 INSERT INTO Produto VALUES (NEW.ProductCode, NEW.ProductDescription, NEW.UnitPrice, NEW.UnitOfMeasure);
END;

CREATE TRIGGER insert_Fatura AFTER INSERT ON Fatura
BEGIN
 INSERT INTO Fatura(InvoiceNo, InvoiceDate, CustomerID) VALUES (NEW.InvoiceNo, NEW.InvoiceDate, NEW.CustomerID);
END;

CREATE TRIGGER insert_Line AFTER INSERT ON Line
BEGIN
 INSERT INTO Line(LineNumber, ProductCode, Quantity, UnitPrice, CreditAmount, TaxID, FaturaIDL) VALUES (NEW.LineNumber, NEW.ProductCode, NEW.Quantity, NEW.UnitPrice, NEW.CreditAmount, NEW.TaxID, NEW.FaturaIDL);
END;


CREATE TRIGGER insert_DocumentTotals AFTER INSERT ON Line
BEGIN
 INSERT INTO DocumentTotals(TaxPayable, NetTotal, GrossTotal, FaturaID) VALUES (NEW.TaxPayable, NEW.NetTotal, NEW.GrossTotal, NEW.FaturaID);
END;



DROP TRIGGER update_UnitPrice;
DROP TRIGGER update_CreditAmount;
DROP TRIGGER update_TaxPayable;
DROP TRIGGER update_NetTotal;
DROP TRIGGER update_GrossTotal;


DROP TRIGGER update_TaxType;
DROP TRIGGER update_TaxPercentage;
DROP TRIGGER update_AddressDetail;
DROP TRIGGER update_City;
DROP TRIGGER update_PostalCode1;
DROP TRIGGER update_PostalCode2;
DROP TRIGGER update_Country;
DROP TRIGGER update_CustomerTaxID;
DROP TRIGGER update_CompanyName;
DROP TRIGGER update_BillingAddressID;
DROP TRIGGER update_Email;
DROP TRIGGER update_EmailUtilizadores;
DROP TRIGGER update_Username;
DROP TRIGGER update_Password;
DROP TRIGGER update_TipoUtilizadores;
DROP TRIGGER update_ProductDescription;
DROP TRIGGER update_UnitPrice_Produto;
DROP TRIGGER update_UnitOfMeasure;
DROP TRIGGER update_InvoiceNo;
DROP TRIGGER update_InvoiceDate;
DROP TRIGGER update_CustomerID;
DROP TRIGGER update_LineNumber;
DROP TRIGGER update_ProductCode;
DROP TRIGGER update_Quantity;
DROP TRIGGER update_TaxID;
DROP TRIGGER update_FaturaIDL;
DROP TRIGGER update_FaturaID;
DROP TRIGGER insert_Tax;
DROP TRIGGER insert_BillingAddress;
DROP TRIGGER insert_Cliente;
DROP TRIGGER insert_Utilizadores;
DROP TRIGGER insert_Produto;
DROP TRIGGER insert_Fatura;
DROP TRIGGER insert_Line;
DROP TRIGGER insert_DocumentTotals;
