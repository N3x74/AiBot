# **ChatAI bot - NanoTel**  

This guide explains how to set up and run your Telegram bot using **NanoTel**.  

---

## **1. Prerequisites**  

Before starting, make sure you have the following:  

✅ **PHP 8.0+**  
✅ **Composer**  
✅ **A Telegram bot with a valid token**  

---

## **2. Setup Instructions**  

### **1. Clone the Project (if applicable)**  

If the source code is hosted on GitHub, you can clone it using:  

```sh
git clone https://github.com/N3x74/ChatAi.git
cd AiBot
```

### **2. Install Dependencies**

Run the following command to install all required packages:

```sh
composer install
```

### **3. Configure `config.php`**

Open the `config.php` file and update the necessary details:

```php
$BOT_CONFIG = [
    "BOT" => [
        "TOKEN"    => "<TOKEN>", // BOT TOKEN
        "NAME"     => "<NAME>", // BOT NAME
    ],
];
```

---

## **3. Set Up the Webhook**  

To activate your bot, open the following URL in your browser:  

```
https://api.telegram.org/botYOUR_BOT_TOKEN/setWebhook?url=https://yourdomain.com/main.php
```

✅ **Note:** Replace `YOUR_BOT_TOKEN` with your actual bot token and `yourdomain.com` with your server’s real domain.  

Once you open this link, you should see a JSON response like:

```json
{"ok":true, "result":true, "description":"Webhook was set"}
```

This means your bot is now connected and ready to receive messages! 🚀

---

## **4. Running the Bot**  

Once the webhook is set up, your bot should be ready to receive and process messages automatically.