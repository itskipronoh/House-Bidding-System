## House Bidding System



### Overview

The House Bidding System is a web application designed to streamline the process of buying and selling houses through online bidding. Users can register as either buyers or sellers. Buyers can view available houses, place bids on properties, and manage their bidding activities. Sellers can list their properties for auction, view bids on their houses, and manage the auction process.

### Features

## User Registration and Authentication
  - Users can register as buyers or sellers.
  - Secure login authentication for registered users.

  ## Buyer Features
  - Browse available houses for auction.
  - Place bids on houses they are interested in.
  - View and manage their bidding activities.

  ## Seller Features
  - List properties for auction with details and starting bid price.
  - View bids on their listed houses.
  - Manage the auction process by accepting or rejecting bids.

  ## Dashboard for Buyers and Sellers
  - Buyers and sellers have personalized dashboards displaying relevant information.
  - Buyers can see their active bids and bidding history.
  - Sellers can view bids on their listed houses and manage the auction status.

  ## Real-time Updates
  - Users receive real-time notifications for new bids, bid status changes, and auction updates.

### Technologies Used

- **Frontend:**
  - HTML
  - CSS
  - JavaScript

- **Backend:**
  - PHP
  - PostgreSQL (Database)

### Installation

1. Clone the repository:
   ```bash
   git clone https://github.com/your-username/house-bidding-system.git
   ```

2. Import the PostgreSQL database schema from `database/schema.sql` into your PostgreSQL database.

3. Update the database connection settings in `config.php` with your PostgreSQL credentials.

4. Start your PHP development server:
   ```bash
   php -S localhost:8000
   ```

5. Access the application at `http://localhost:8000` in your web browser.

### Usage

- **User Registration:**
  - Upon accessing the application, users can register as buyers or sellers with their email and password.

- **Buyer Functions:**
  - **Browse Houses:**
    - Buyers can view the list of available houses for auction.
  - **Place Bids:**
    - To bid on a house, buyers can enter their bid amount and submit.
  - **Manage Bids:**
    - Buyers can view their active bids, modify bid amounts, or withdraw bids.

- **Seller Functions:**
  - **List Properties:**
    - Sellers can list their properties for auction, providing details and starting bid prices.
  - **View Bids:**
    - Sellers can see all bids made on their properties.
  - **Manage Auction:**
    - Sellers can accept or reject bids and manage the auction process.

- **Dashboard:**
  - Upon logging in, users are directed to their respective dashboards.
  - Buyers see their active bids and bidding history.
  - Sellers view bids on their listed properties and manage auctions.

### License

This project is licensed under the MIT License 

