import csv

with open('meals.csv', newline='', encoding='utf-16') as csvfile:
    reader = csv.reader(csvfile, delimiter='\t')
    rows = list(reader)

with open('meals2.csv', 'w', newline='', encoding='utf-8') as csvfile:
    writer = csv.writer(csvfile, delimiter=';')
    writer.writerows(rows)