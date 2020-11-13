#!/usr/bin/env python
# coding: utf-8

# In[100]:


#!pip install Faker
import pandas as pd
import numpy as np
import random
import string

from faker import Faker
from datetime import date

fake = Faker()
num_of_records = 1000
random_string = 'hello'

# Parameters
salutations_male = ['Master', 'Mr.']
salutations_female = ['Mrs.', 'Miss', 'Ms.']
email_extensions = ['gmail.com', 'yahoo.com', 'mail.com', 'yandex.ru', 'outlook.com']
user_types = ['s', 'a', 'c', 'p', 'd']
dates = [date(2018, 1, 1), date.today()]
cities = ['Ajax', 'Brooklin', 'Bowmanville', 'Oshawa', 'Pickering', 'Port Perry', 'Whitby']
provinces = ['AB', 'BC', 'MB', 'NB', 'NF', 'NS', 'NT', 'NU', 'ON', 'PE', 'PQ', 'SK', 'YT']
postal_code_first = ['A', 'B', 'C', 'E', 'G', 'H', 'J', 'K', 'L', 'M', 'N', 'P', 'R', 'S', 'T', 'V', 'X', 'Y']
postal_code = ['A', 'B', 'C', 'E', 'G', 'H', 'J', 'K', 'L', 'M', 'N', 'P', 'R', 'S', 'T', 'V', 'X', 'Y', 'W', 'Z']
contact_method = ['e', 'p', 'l']

# Dataframes
df_persons = pd.DataFrame(columns = ['Salutation', 'FirstName', 'LastName'])
df_users = pd.DataFrame(columns = ['UserId', 'Password', 'Email', 'UserType', 'EnrollDate', 'LastAccess'])

# Generate names + salutations / populate df_users
for i in range(num_of_records):
    if random.randrange(1, 3) == 1:
        df_persons.loc[i] = [random.choice(salutations_male), fake.first_name_male(), fake.last_name()]
    else:
        df_persons.loc[i] = [random.choice(salutations_female), fake.first_name_female(), fake.last_name()]
        
    df_users.at[i, 'UserId'] = df_persons.loc[i]['FirstName'].lower()
    df_users.at[i, 'Password'] = random_string + df_persons.loc[i]['FirstName'].lower()
    df_users.at[i, 'Email'] = df_persons.loc[i]['FirstName'].lower() + '.' + df_persons.loc[i]['LastName'].lower() + '@' + random.choice(email_extensions)
    df_users.at[i, 'UserType'] = random.choices(user_types, [5, 35, 45, 10, 5])[0]
    df_users.at[i, 'EnrollDate'] = date.fromordinal(random.randint(dates[0].toordinal(), dates[1].toordinal()))
    df_users.at[i, 'LastAccess'] = date.fromordinal(random.randint(df_users.at[i, 'EnrollDate'].toordinal(), dates[1].toordinal()))

# Populate df_persons
df_persons.insert(0, 'UserId', df_users['UserId'])
df_persons = df_persons.join(pd.DataFrame(columns = ['Street1', 'Street2', 'City', 'Province', 'PostalCode', 'PrimaryPhone', 'SecondaryPhone', 'FaxNumber', 'ContactMethod']))
for i in range(num_of_records):
    df_persons.at[i, 'Street1'] = fake.street_address()
    df_persons.at[i, 'Street2'] = fake.street_address()  
    df_persons.at[i, 'City'] = random.choice(cities) 
    df_persons.at[i, 'Province'] = random.choice(provinces)
    df_persons.at[i, 'PostalCode'] = random.choice(postal_code_first) + str(random.randint(0, 9)) + random.choice(postal_code) + str(random.randint(0, 9)) + random.choice(postal_code) + str(random.randint(0, 9))
    df_persons.at[i, 'PrimaryPhone'] = str(random.randint(200, 999)) + str(random.randint(200, 999)) + str(random.randint(0, 9)) + str(random.randint(0, 9)) + str(random.randint(0, 9)) + str(random.randint(0, 9))
    df_persons.at[i, 'SecondaryPhone'] = str(random.randint(200, 999)) + str(random.randint(200, 999)) + str(random.randint(0, 9)) + str(random.randint(0, 9)) + str(random.randint(0, 9)) + str(random.randint(0, 9))
    df_persons.at[i, 'FaxNumber'] = str(random.randint(200, 999)) + str(random.randint(200, 999)) + str(random.randint(0, 9)) + str(random.randint(0, 9)) + str(random.randint(0, 9)) + str(random.randint(0, 9))
    df_persons.at[i, 'ContactMethod'] = random.choice(contact_method)

while (len(df_users.loc[df_users.duplicated(subset="UserId", keep='first')]) != 0):
    for i in df_users.loc[df_users.duplicated(subset="UserId", keep='first')].index:
        df_users.loc[i]['UserId'] = df_users.loc[i]['UserId'] + random.choice(string.ascii_letters).lower()
df_persons['UserId'] = df_users['UserId']
    
with open('users.sql', 'a') as file:
    for i in range(num_of_records):
        values = []
        for x in df_users.loc[i]:
            values.append(x)
        file.write('INSERT INTO users VALUES(\'' + values[0] + '\', md5(\'' + values[1] + '\'), \'' + values[2] + '\', \'' + values[3] + '\', \'' + values[4].strftime('%Y-%m-%d') + '\', \'' + values[5].strftime('%Y-%m-%d') + '\');\n')
file.close()

with open('persons.sql', 'a') as file:
    for i in range(num_of_records):
        values = []
        for x in df_persons.loc[i]:
            values.append(x)
        file.write('INSERT INTO persons VALUES(\'' + values[0] + '\', \'' + values[1] + '\', \'' + values[2] + '\', \'' + values[3] + '\', \'' + values[4] + '\', \'' + values[5] + '\', \'' + values[6] + '\', \'' + values[7] + '\', \'' + values[8] + '\', \'' + values[9] + '\', \'' + values[10] + '\', \'' + values[11] + '\', \'' + values[12] + '\');\n')
file.close()


# In[ ]:




