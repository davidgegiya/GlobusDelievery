from distutils.log import error
from os import write
from time import sleep
import requests
from bs4 import BeautifulSoup
import csv
import re
import os

URL = 'https://broniboy.ru/moscow/restaurants/'
HEADERS = {
    'user-agent': 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/91.0.4472.164 YaBrowser/21.6.4.693 Yowser/2.5 Safari/537.36'}
HOST = 'https://broniboy.ru'
restaurants = []
rest_title = 'ББ&Бургерс'


def get_html(url, params=None):
    r = requests.get(url, headers=HEADERS, params=params)
    # f = open('workfile.html', 'w', encoding="utf-8")
    # f.write(r.text)
    return r


def get_content(html):
    soup = BeautifulSoup(html, 'html.parser')
    print(len(soup.find_all('span', class_='_1n6gjbc')))
    # print(soup.find_all('span', class_='_1n6gjbf'))

    # items = soup.find_all('img', class_='_1n6gjb8')
    items = soup.find_all('h4', class_='_1oqru0l5')
    print(len(items))
    # for page in range(2, 17):
    #     soup = BeautifulSoup(
    #         get_html(URL+'?page='+str(page)).text, 'html.parser')
    #     items += soup.find_all('a', class_='_1n6gjb2')
    # print(len(items))

    for item in items:
        # img_link = HOST + item.get('srcset').split()[0]
        # link = HOST + item.get('href')
        
        title = item.get_text()
        if(title == 'Популярное' or title == rest_title):
            continue

        # print(soup)
        # try:
        #     link2 = HOST + item.find('a', class_='vendor-item__link').get('href')
        #     soup2 = BeautifulSoup(get_html(link2).text, 'html.parser')
        #     items2 = soup2.find_all('div', class_='vendor-menu__section')
        #     for item2 in items2:
        #         category_name = item2.find('h2', class_='vendor-menu__category-title').get_text(strip=True)
        #         if(category_name == 'Популярные'):
        #             continue
        #         menu_items = item2.find_all('li', class_='menu-product')
        #         for menu_item in menu_items:
        #             product_image = menu_item.find('div', class_='menu-product__img').get('data-src')
        #             product_title = menu_item.find('div', class_='menu-product__title').get_text()
        #             product_price = menu_item.find('div', class_='menu-product__price').get_text(strip=True)
        #             restaurants.append({
        #                 'image': product_image,
        #                 'rest_title': title,
        #                 'category_name': category_name,
        #                 'product_title': product_title,
        #                 'price': product_price
        #             })
        restaurants.append({
            'title': title
        })
        # except Exception as er:
        #     print(er)
        #     break


def save_file(items, path):
    with open(path, 'a', newline='', encoding='utf-16') as file:
        writer = csv.writer(file, delimiter='\t')
        for item in items:
            # writer.writerow([item['rest_title'], item['category_name'],item['product_title'], item['price'], item['image']])
            writer.writerow([rest_title, item['title']])


def parse():
    html = get_html(URL)
    file_path = os.getcwd()+'/'+rest_title+'.html'
    print(file_path)
    if os.path.exists(file_path):
        # Read the file contents as a text string
        with open(file_path, 'r') as f:
            file_contents = f.read()
            get_content(file_contents)
            save_file(restaurants, 'categories.csv')
            print('Success!')
    else:
        print('Error')


parse()
