# import required libraries
import mysql.connector
import os
import requests
from PIL import Image
from google_images_search import GoogleImagesSearch

# define the MySQL database credentials
db_host = "127.0.0.1"
db_user = "root"
db_password = "1"
db_name = "globusdelivery"
table_name = "restaurants"

# define the root image directory
root_dir = "C:/Users/User/Desktop/restaurants/"

# connect to the database and get the rows to generate images for
db = mysql.connector.connect(host=db_host, user=db_user, password=db_password, database=db_name)
cursor = db.cursor()
cursor.execute("SELECT id, name, image FROM "+table_name)
rows = cursor.fetchall()

# create the image directories if they do not exist
for row in rows:
    restaurant_dir = root_dir + row[1] + "/"
    if not os.path.exists(restaurant_dir):
        os.makedirs(restaurant_dir)

# generate the images and update the image cell in the table
gis = GoogleImagesSearch('AIzaSyBrEKms-ED0IZkFnQimeXwxRj8_KQ5g284', 'c0ad77c4aba9e4f91')

for row in rows:
    restaurant_name = row[1]
    restaurant_dir = root_dir + restaurant_name + "/"
    image_name = str(row[0]) + ".jpg"
    image_path = restaurant_dir + image_name
    
    # check if the image was already downloaded
    if not os.path.exists(image_path):
        # download the first image for the restaurant from Google Images
        query = 'ресторан '+restaurant_name + ' логотип'
        print(query)
        gis.search({'q': query, 'num': 1, 'imgSize': 'large', 'safe': 'active'}, restaurant_dir, custom_image_name=image_name)
        path__ = gis.results()[0]
        print(restaurant_name)
        # # save the downloaded image to the directory
        # downloaded_images = os.listdir(restaurant_dir)
        # print(downloaded_images)
        # if len(downloaded_images) > 0:
        #     image_file = downloaded_images[0]
        #     os.rename(restaurant_dir+image_file, image_path)
            
        #     # open the image and resize it
        #     image = Image.open(image_path)
        #     image = image.resize((300, 200))
        #     image.save(image_path)
            
        # # if no image is found, create an empty image
        # else:
        #     image = Image.new('RGB', (300, 200), (255, 255, 255))
        #     image.save(image_path)
        
    # update the image cell in the table
    cursor.execute("UPDATE "+table_name+" SET image='"+image_path+"' WHERE id='"+str(row[0])+"'")
    db.commit()
    
# close the database connection
db.close()