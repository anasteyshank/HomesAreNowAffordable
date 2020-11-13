#!/usr/bin/env python
# coding: utf-8

# In[62]:


#!pip install psycopg2
import psycopg2
import pandas as pd
import numpy as np
import random
import string

from datetime import date

def db_conn():
    return psycopg2.connect("host=127.0.0.1 dbname=group18 user=postgres password=group18.ca")

# Parameters
num_of_records = 1500
user_ids = pd.read_sql_query('SELECT user_id FROM users WHERE user_type=\'a\'', db_conn())['user_id'].values
statuses = pd.read_sql_query('SELECT * FROM listing_status', db_conn())['value'].values
min_price = 50000
max_price = 3000000
headlines = pd.read_csv('headlines.txt', sep="\n", header=None)[0].values
descriptions = pd.read_csv('randomtext_descriptions.txt', sep="\n\n", header=None)[0].values
postal_code_first = ['A', 'B', 'C', 'E', 'G', 'H', 'J', 'K', 'L', 'M', 'N', 'P', 'R', 'S', 'T', 'V', 'X', 'Y']
postal_code = ['A', 'B', 'C', 'E', 'G', 'H', 'J', 'K', 'L', 'M', 'N', 'P', 'R', 'S', 'T', 'V', 'X', 'Y', 'W', 'Z']
image = 0
cities = pd.read_sql_query('SELECT * FROM city', db_conn())['value'].values
property_options = pd.read_sql_query('SELECT * FROM property_options', db_conn())['value'].values
bedrooms = pd.read_sql_query('SELECT * FROM bedrooms', db_conn())['value'].values
bathrooms = pd.read_sql_query('SELECT * FROM bathrooms', db_conn())['value'].values
building_types = pd.read_sql_query('SELECT * FROM building_type', db_conn())['value'].values
transaction_types = pd.read_sql_query('SELECT * FROM transaction_type', db_conn())['value'].values
basement_types = pd.read_sql_query('SELECT * FROM basement_type', db_conn())['value'].values
parking = pd.read_sql_query('SELECT * FROM parking', db_conn())['value'].values
housing_style = pd.read_sql_query('SELECT * FROM housing_style', db_conn())['value'].values
flooring = pd.read_sql_query('SELECT * FROM flooring', db_conn())['value'].values

# Listings Dataframe
df_listings = pd.DataFrame(columns = ['UserId', 'Status', 'Price', 'Headline', 'Description', 'PostalCode', 'Image',
                                      'City', 'PropertyOption', 'Bedroom', 'Bathroom', 'BuildingType', 'TransactionType',
                                      'BasementType', 'Parking', 'HousingStyle', 'Flooring'])

for i in range(num_of_records):
    df_listings.at[i, 'UserId'] = random.choice(user_ids) 
    df_listings.at[i, 'Status'] = random.choice(statuses) 
    df_listings.at[i, 'Price'] = random.randint(min_price, max_price)
    df_listings.at[i, 'Headline'] = random.choice(headlines) 
    df_listings.at[i, 'Description'] = random.choice(descriptions) 
    df_listings.at[i, 'PostalCode'] = random.choice(postal_code_first) + str(random.randint(0, 9)) + random.choice(postal_code) + str(random.randint(0, 9)) + random.choice(postal_code) + str(random.randint(0, 9)) 
    df_listings.at[i, 'Image'] = image
    df_listings.at[i, 'City'] = random.choice(cities) 
    df_listings.at[i, 'PropertyOption'] = random.choice(property_options) 
    df_listings.at[i, 'Bedroom'] = random.choice(bedrooms) 
    df_listings.at[i, 'Bathroom'] = random.choice(bathrooms) 
    df_listings.at[i, 'BuildingType'] = random.choice(building_types) 
    df_listings.at[i, 'TransactionType'] = random.choice(transaction_types) 
    df_listings.at[i, 'BasementType'] = random.choice(basement_types) 
    df_listings.at[i, 'Parking'] = random.choice(parking) 
    df_listings.at[i, 'HousingStyle'] = random.choice(housing_style) 
    df_listings.at[i, 'Flooring'] = random.choice(flooring) 

with open('listings.sql', 'a') as file:
    for i in range(num_of_records):
        values = []
        for x in df_listings.loc[i]:
            values.append(str(x))
        file.write('INSERT INTO listings VALUES(DEFAULT, \'' + values[0] + '\', \'' + values[1] + '\', \'' + values[2] + '\', \'' 
                   + values[3] + '\', \'' + values[4] + '\', \'' + values[5] + '\', \'' + values[6] + '\', \'' + values[7] 
                   + '\', \'' + values[8] + '\', \'' + values[9] + '\', \'' + values[10] + '\', \'' + values[11] 
                   + '\', \'' + values[12] + '\', \'' + values[13] + '\', \'' + values[14] + '\', \'' + values[15]
                   + '\', \'' + values[16] + '\');\n')
file.close()


# In[ ]:




