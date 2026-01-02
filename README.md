![Hero Image](https://raw.githubusercontent.com/Cybeles-Eos/ServEase/main/public/images/meta-cover.png)


### Group 8 - ServEase
Hello! We are **Group 8** 👋 Servease is a collaborative project by Group 8, aimed at delivering an efficient and user-friendly service management platform. The project combines innovative ideas and teamwork to create a functional solution that addresses real-world challenges. This repository contains the full source code, documentation, and resources for Servease.



### Frontend Tools
[![Blade](https://img.shields.io/badge/Blade-Laravel-F05340.svg?logo=laravel&logoColor=white)](https://laravel.com/docs/10.x/blade)
[![HTML](https://img.shields.io/badge/HTML-5-E34F26.svg?logo=html5&logoColor=white)](https://developer.mozilla.org/en-US/docs/Web/HTML)
[![CSS](https://img.shields.io/badge/CSS-3-1572B6.svg?logo=css3&logoColor=white)](https://developer.mozilla.org/en-US/docs/Web/CSS)
[![SCSS](https://img.shields.io/badge/SCSS-Sass-CD6799.svg?logo=sass&logoColor=white)](https://sass-lang.com/)
[![JavaScript](https://img.shields.io/badge/JavaScript-ES6+-F7DF1E.svg?logo=javascript&logoColor=black)](https://developer.mozilla.org/en-US/docs/Web/JavaScript)
[![Bootstrap](https://img.shields.io/badge/Bootstrap-5.3-7952B3.svg?logo=bootstrap&logoColor=white)](https://getbootstrap.com/)
[![jQuery](https://img.shields.io/badge/jQuery-3.7-0769AD.svg?logo=jquery&logoColor=white)](https://jquery.com/)


<!-- <img src="https://cdn.jsdelivr.net/gh/devicons/devicon/icons/html5/html5-original.svg" height="30"/><img src="https://cdn.jsdelivr.net/gh/devicons/devicon/icons/css3/css3-original.svg" height="30"/><img src="https://cdn.jsdelivr.net/gh/devicons/devicon/icons/javascript/javascript-original.svg" height="30"/><img src="https://cdn.jsdelivr.net/gh/devicons/devicon/icons/react/react-original.svg" height="30"/><img src="https://cdn.jsdelivr.net/gh/devicons/devicon/icons/bootstrap/bootstrap-original.svg" height="30"/>
<img src="https://cdn.jsdelivr.net/gh/devicons/devicon@latest/icons/tailwindcss/tailwindcss-original.svg" height="35" />
<img src="https://cdn.jsdelivr.net/gh/devicons/devicon/icons/jquery/jquery-original.svg" height="30"/> -->


### Backend Tools
[![PHP](https://img.shields.io/badge/PHP-8.x-777BB4.svg?logo=php&logoColor=white)](https://www.php.net/)
[![Laravel](https://img.shields.io/badge/Laravel-11.x-FF2D20.svg?logo=laravel&logoColor=white)](https://laravel.com/)
[![MySQL](https://img.shields.io/badge/MySQL-8.x-4479A1.svg?logo=mysql&logoColor=white)](https://www.mysql.com/)
<!-- <img src="https://cdn.jsdelivr.net/gh/devicons/devicon/icons/php/php-original.svg" height="30"/>    <img src="https://cdn.jsdelivr.net/gh/devicons/devicon/icons/laravel/laravel-original.svg" height="30"/>    <img src="https://cdn.jsdelivr.net/gh/devicons/devicon/icons/mysql/mysql-original.svg" height="30"/> -->


### Tools
[![Figma](https://img.shields.io/badge/Figma-Design_Tool-F24E1E.svg?logo=figma&logoColor=white)](https://figma.com/)
[![Canva](https://img.shields.io/badge/Canva-Design-00C4CC.svg?logo=canva&logoColor=white)](https://www.canva.com/)

<hr> 

# 🧰 **ServEase System**

Servease is a collaborative project by Group 8, aimed at delivering an efficient and user-friendly service management platform. The project combines innovative ideas and teamwork to create a functional solution that addresses real-world challenges. This repository contains the full source code, documentation, and resources for Servease.


## 🔧 Prerequisites

Ensure you have the following tools installed on your system:

1. **Git**: [Download Git](https://git-scm.com/)
2. **Composer**: [Download Composer](https://getcomposer.org/)
3. **Node.js and npm**: [Download Node.js](https://nodejs.org/) (npm is included with Node.js)
4. **PHP development environment**: Use XAMPP.

## ⚙️ Installation & Setup

Follow these steps to get the application up and running locally:

1. Clone the project repository

   ```sh
   git clone https://github.com/Cybeles-Eos/ServEase.git
   cd servease
   ```

2. Run This Command In the Terminal

   ```sh
    git checkout -b <your-initials-plus-lastname>     #Ex. "dijcruz" "dbbarcelon"
    git pull origin main
    git pull origin staging
   ```

3. Install Backend and Frontend Dependencies

   ```sh
    composer install
    npm install
   ```

4. Configure Environment Variables for applications

   - Create .env files

   ```sh
    cp .env.example .env
   ```

   - Update the necessary variables based on your setup

5. Generate Application Key

   ```sh
   php artisan key:generate
   ```

6. Run Database Migrations and Data Seeder

   ```sh
   php artisan migrate --seed
   ```

7. Start the Development Servers

   ```sh
   composer run dev
   ```

8. Access the applications
   - http://127.0.0.1:8000

   **Note:** You may change the application URL in the .env file if the default address is not available.

