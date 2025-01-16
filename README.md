
# **House Rental System**

## **Purpose**

The **House Rental System** is a web application designed to provide an easy-to-use platform for both tenants and property owners. The system enables tenants to search for properties, book them, view and update their profiles, and communicate with property owners. Property owners, on the other hand, can manage their properties, view their bookings, and interact with tenants through messages. This platform enhances the property renting experience for both tenants and property owners.

---

## **Technologies Used**

- **Frontend**:
  - HTML
  - CSS
  - Bootstrap
  - JavaScript

- **Backend**:
  - PHP
  - MySQL

---

## **Features**

### **Tenant Features**

- **Search Properties**: Tenants can search for properties based on various filters such as address, district, city, rent, and property type.
- **View Profile**: Tenants can view and update their profiles.
- **Booked Properties**: Tenants can view the list of properties they have booked.
- **View Property Details**: Tenants can see detailed information about a property, including images and description.
- **Rate and Review Properties**: Tenants can rate and leave reviews for properties they have stayed in.
- **Send Messages**: Tenants can send messages to property owners for inquiries or other communication.
- **Book Properties**: Tenants can book properties they are interested in.

### **Owner Features**

- **View and Update Profile**: Owners can view and update their profiles, including contact information and other details.
- **Manage Messages**: Owners can view messages sent by tenants and respond accordingly.
- **Add Properties**: Owners can add new properties to the system, providing details such as address, type, rent, and photos.
- **Manage Properties**: Owners can view, edit, or delete their listed properties.
- **View Property Bookings**: Owners can see which properties are booked by tenants, including tenant details.

---

## **Project Structure**

```
/House-Rental-System
├── /assets
│   ├── /property-photos        # Directory for property images
├── /frontend                   # Frontend files (HTML, CSS, JavaScript)
├── /backend                    # Backend files (PHP, MySQL)
├── index.php                   # Main entry point (Homepage)
└── README.md                   # Project documentation
```

---

## **How to Use**

### **Frontend Setup**

1. **Clone the repository**:
   ```bash
   git clone https://github.com/fahimajaina/House-Rental-System.git
   ```

2. **Navigate to the frontend directory**:
   ```bash
   cd frontend
   ```

3. **Install dependencies**:
   - Since the frontend is built using HTML, CSS, and JavaScript, you don't need to install any dependencies. You can directly open the HTML files in a browser.

4. **Run the frontend**:
   - Simply open the `index.html` file in your web browser to start using the system.

### **Backend Setup**

1. **Clone the repository** (if not done already):
  
   git clone https://github.com/fahimajaina/House-Rental-System.git
   ```

2. **Navigate to the backend directory**:
   
   cd backend
   ```

3. **Database Setup**:
   - Import the provided `house_rental_system.sql` file to set up the MySQL database.
   - Configure the database connection in your `config.php` file by updating the database credentials (host, username, password, database name).

4. **Run the backend**:
   - The backend is built using PHP, so you can run it using a local PHP server:
   
   php -S localhost:8000
   ```
   - This will start the server, and you can access the system by visiting `http://localhost:8000` in your browser.

---

## **How It Works**

### **User Flow (Tenant)**

1. **Search for Properties**: The tenant searches for properties using various filters such as address, district, city, rent, and property type.
2. **View Property Details**: Tenants can view detailed information about available properties.
3. **Book a Property**: After selecting a property, tenants can proceed with booking it.
4. **View and Rate**: After staying at the property, tenants can rate and leave reviews.
5. **Update Profile**: Tenants can update their personal details anytime.

### **Admin Flow (Owner)**

1. **Manage Properties**: Property owners can add, edit, or delete their properties.
2. **Manage Messages**: Owners can view and respond to messages from tenants.
3. **View Bookings**: Owners can see which properties are booked, along with the tenant's details.

---

## **Additional Notes**

- **Property Photos**: The property images are stored in the `/assets/property-photos` directory.
- **User Authentication**: Ensure users are logged in before they can access tenant or owner features.
- **Admin Panel**: Although not explicitly mentioned in the features, an admin panel could be added to manage all users and properties in the future.


---
## **Resources**

[Presentation Slide](https://drive.google.com/file/d/14DSwmQZxmYF2re6iEGlFU223P3SxfdnQ/view?usp=sharing)

[Project Demo Video](https://drive.google.com/file/d/1FVxlweeV0ko7SREJLXg9jkaOY79dKJuH/view?usp=sharing)


## **Contributions**

Feel free to fork this project and submit pull requests. If you encounter any bugs or want to suggest improvements, open an issue in the repository.
```

---




