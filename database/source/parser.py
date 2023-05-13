from distutils.log import error
from os import write
from time import sleep
import requests
from bs4 import BeautifulSoup
import csv
import re

URL = 'https://broniboy.ru/moscow/restaurants/'
HEADERS = {
    'user-agent': 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/91.0.4472.164 YaBrowser/21.6.4.693 Yowser/2.5 Safari/537.36'}
HOST = 'https://broniboy.ru'
restaurants = []


def get_html(url, params=None):
    r = requests.get(url, headers=HEADERS, params=params)
    # f = open('workfile.html', 'w', encoding="utf-8")
    # f.write(r.text)
    return r


def get_content(html):
    soup = BeautifulSoup(html, 'html.parser')
    print(len(soup.find_all('span', class_='_1n6gjbc')))
    # print(soup.find_all('span', class_='_1n6gjbf'))

    items = soup.find_all('a', class_='_1n6gjb2')

    # for page in range(2, 17):
    #     soup = BeautifulSoup(
    #         get_html(URL+'?page='+str(page)).text, 'html.parser')
    #     items += soup.find_all('a', class_='_1n6gjb2')
    # print(len(items))

    for item in items:
        try:
            rest_img = item.find(
                'span', class_='vendor-item__cover').get('data-src')
        except:
            rest_img = ""
        try:
            title = item.find(
                'span', class_='_1n6gjbd').get_text()
        except:
            title = ""
        try:
            delivery_time = item.find(
                'span', class_='_1n6gjbf').get_text(strip=True)
        except:
            delivery_time = 'неизвестно'
        try:
            delivery_price = item.find(
                'span', class_='_1n6gjbh').get_text()
        except:
            delivery_price = 'неизвестно'
        try:
            pricing_level = item.find('span', class_='_1n6gjbc').get_text(strip=True).count('₽')
        except:
            pricing_level = 1

        link = HOST + item.get('href')

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
            'image': rest_img,
            'rest_title': title,
            'delivery_time': delivery_time,
            'delivery_price': delivery_price,
            'pricing_level': pricing_level
        })
        # except Exception as er:
        #     print(er)
        #     break


def save_file(items, path):
    with open(path, 'a', newline='', encoding='utf-16') as file:
        writer = csv.writer(file, delimiter='\t')
        for item in items:
            # writer.writerow([item['rest_title'], item['category_name'],item['product_title'], item['price'], item['image']])
            writer.writerow([item['rest_title'], item['image'],
                            item['delivery_time'], item['delivery_price'], item['pricing_level']])


def parse():
    html = get_html(URL)
    if html.status_code == 200:
        get_content(html.text)
        save_file(restaurants, 'restaurants.csv')
        print('Success!')
    else:
        print('Error')


parse()
