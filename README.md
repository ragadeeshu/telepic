telepic
=======

Remote picture viewer tool

=======

NOTE: This project is under an noncommercial license. Use it as you want for yourself, friends and family. But don't use it to make a fortune. Thank you.

=======

First off, sorry for the hard-coded static variables instead of a config file, was in a hurry towards the end as this project had a deadline. Also, sorry for following two different standards on file names.

You will thus need to enter appropriate values in common.php, clientCommon.php and PhpCaller.java. You also need to compile the client code yourself. I compiled it with java 8 in order to run it on a Raspberry Pi.

Your database needs to have the following tables:


users


Column	  Type	      Null	Default	Comments

id	      int(11)	    No 	 	 
username	varchar(30)	No 	 	 
password	varchar(64)	No 	 	 
salt	    varchar(3)	No 	 	 


Indexes


Keyname	  Type	Unique	Packed	Column	  Cardinality	Collation	Null

PRIMARY	  BTREE	Yes	    No	    id	      8	          A	        No
username	BTREE	Yes	    No	    username  8	          A	        No


pictures


Column	    Type	        Null	Default	Comments

ID	        int(11)	      No 	 	 
path	      varchar(200)	No 	 	 
description	varchar(500)	No 	 	 
owner	      varchar(30)	  No 	 	 
date	      int(11)	      No 	 	 

Indexes

Keyname	Type	Unique	Packed	Column	Cardinality	Collation	Null

PRIMARY	BTREE	Yes	    No	    ID	    34	        A	        No
