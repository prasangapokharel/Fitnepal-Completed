import requests
from bs4 import BeautifulSoup

from retry import retry

@retry(ConnectionError, tries=3, delay=1)
def scrape_nepal_stock_exchange():
    url = 'https://nepalstock.com/today-price'
    response = requests.get(url, verify=False)
    # Rest of your scraping logic
    
    
def scrape_nepal_stock_exchange():
    url = 'https://nepalstock.com/today-price'
    response = requests.get(url, verify=False)
    if response.status_code == 200:
        soup = BeautifulSoup(response.content, 'html.parser')
        table = soup.find('table', class_='table my-table table-striped')
        if table:
            rows = table.find_all('tr')
            for row in rows:
                cells = row.find_all('td')
                if cells:
                    # Extract the data from cells and process as needed
                    company_name = cells[1].text.strip()
                    symbol = cells[2].text.strip()
                    last_close_price = cells[3].text.strip()
                    opening_price = cells[4].text.strip()
                    # Continue extracting other data fields as needed
                    print(company_name, symbol, last_close_price, opening_price)
        else:
            print("Table not found on the page.")
    else:
        print("Failed to fetch the webpage.")

scrape_nepal_stock_exchange()
