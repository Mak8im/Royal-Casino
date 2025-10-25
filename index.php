<?php
session_start();
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Royal Casino - Премиум азартные игры</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Arial', sans-serif;
        }
        
        body {
            background: linear-gradient(135deg, #0a0a2a, #1a1a3a);
            color: #fff;
            min-height: 100vh;
        }
        
        /* Шапка */
        header {
            background: linear-gradient(to right, #0a0a2a, #2a0a2a);
            padding: 15px 0;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.5);
            position: sticky;
            top: 0;
            z-index: 100;
        }
        
        .header-container {
            max-width: 1200px;
            margin: 0 auto;
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 0 20px;
        }
        
        .logo h1 {
            font-size: 28px;
            background: linear-gradient(to right, #ffd700, #ff9900);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            text-shadow: 0 0 10px rgba(255, 215, 0, 0.3);
        }
        
        .logo span {
            color: #ffd700;
        }
        
        nav ul {
            display: flex;
            list-style: none;
        }
        
        nav ul li {
            margin-left: 25px;
        }
        
        nav ul li a {
            color: #fff;
            text-decoration: none;
            font-weight: bold;
            transition: color 0.3s;
            padding: 8px 15px;
            border-radius: 4px;
        }
        
        nav ul li a:hover {
            color: #ffd700;
            background: rgba(255, 215, 0, 0.1);
        }
        
        .user-actions {
            display: flex;
            align-items: center;
        }
        
        .balance {
            background: rgba(0, 0, 0, 0.3);
            padding: 8px 15px;
            border-radius: 20px;
            margin-right: 15px;
            border: 1px solid #ffd700;
        }
        
        .btn {
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-weight: bold;
            transition: all 0.3s;
        }
        
        .btn-login {
            background: transparent;
            color: #ffd700;
            border: 1px solid #ffd700;
            margin-right: 10px;
        }
        
        .btn-register {
            background: linear-gradient(to right, #ffd700, #ff9900);
            color: #000;
        }
        
        .btn-logout {
            background: transparent;
            color: #ff6b6b;
            border: 1px solid #ff6b6b;
            margin-left: 10px;
        }
        
        .btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.3);
        }
        
        .user-info {
            display: flex;
            align-items: center;
            color: #ffd700;
        }
        
        /* Формы */
        .auth-section {
            max-width: 500px;
            margin: 50px auto;
            padding: 30px;
            background: rgba(255, 255, 255, 0.05);
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.3);
        }
        
        .auth-section h2 {
            text-align: center;
            margin-bottom: 30px;
            color: #ffd700;
            font-size: 28px;
        }
        
        .form-group {
            margin-bottom: 20px;
        }
        
        .form-group label {
            display: block;
            margin-bottom: 8px;
            font-weight: bold;
        }
        
        .form-group input {
            width: 100%;
            padding: 12px;
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: 5px;
            background: rgba(0, 0, 0, 0.3);
            color: #fff;
            font-size: 16px;
        }
        
        .form-group input:focus {
            outline: none;
            border-color: #ffd700;
        }
        
        .btn-submit {
            background: linear-gradient(to right, #ffd700, #ff9900);
            color: #000;
            width: 100%;
            padding: 15px;
            font-size: 18px;
            margin-top: 10px;
        }
        
        .message {
            text-align: center;
            margin-top: 20px;
            padding: 10px;
            border-radius: 5px;
        }
        
        .success {
            background: rgba(0, 255, 0, 0.2);
            border: 1px solid rgba(0, 255, 0, 0.5);
            color: #0f0;
        }
        
        .error {
            background: rgba(255, 0, 0, 0.2);
            border: 1px solid rgba(255, 0, 0, 0.5);
            color: #f00;
        }
        
        .auth-tabs {
            display: flex;
            margin-bottom: 20px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.2);
        }
        
        .auth-tab {
            flex: 1;
            text-align: center;
            padding: 15px;
            cursor: pointer;
            border-bottom: 3px solid transparent;
        }
        
        .auth-tab.active {
            border-bottom: 3px solid #ffd700;
            color: #ffd700;
        }
        
        .auth-form {
            display: none;
        }
        
        .auth-form.active {
            display: block;
        }
        
        /* Остальные стили (герой, игры, акции, футер) остаются такими же */
        .hero {
            background: url('https://images.unsplash.com/photo-1533105079780-92b9be482077?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80') no-repeat center center;
            background-size: cover;
            height: 500px;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
        }
        
        .hero::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(10, 10, 42, 0.7);
        }
        
        .hero-content {
            position: relative;
            z-index: 1;
            text-align: center;
            max-width: 800px;
            padding: 0 20px;
        }
        
        .hero h2 {
            font-size: 48px;
            margin-bottom: 20px;
            text-shadow: 0 2px 10px rgba(0, 0, 0, 0.5);
        }
        
        .hero p {
            font-size: 20px;
            margin-bottom: 30px;
            line-height: 1.6;
        }
        
        .btn-hero {
            background: linear-gradient(to right, #ffd700, #ff9900);
            color: #000;
            padding: 15px 40px;
            font-size: 18px;
            border-radius: 30px;
        }
        
        .games-section {
            max-width: 1200px;
            margin: 50px auto;
            padding: 0 20px;
        }
        
        .section-title {
            text-align: center;
            margin-bottom: 40px;
            font-size: 36px;
            position: relative;
        }
        
        .section-title::after {
            content: '';
            display: block;
            width: 100px;
            height: 3px;
            background: linear-gradient(to right, #ffd700, #ff9900);
            margin: 10px auto;
        }
        
        .games-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
            gap: 25px;
        }
        
        .game-card {
            background: rgba(255, 255, 255, 0.05);
            border-radius: 10px;
            overflow: hidden;
            transition: transform 0.3s, box-shadow 0.3s;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
        }
        
        .game-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.4);
        }
        
        .game-image {
            height: 180px;
            background-size: cover;
            background-position: center;
        }
        
        .game-info {
            padding: 20px;
        }
        
        .game-title {
            font-size: 20px;
            margin-bottom: 10px;
            color: #ffd700;
        }
        
        .game-description {
            font-size: 14px;
            margin-bottom: 15px;
            color: #ccc;
        }
        
        .btn-play {
            background: linear-gradient(to right, #ffd700, #ff9900);
            color: #000;
            width: 100%;
            padding: 10px;
            border-radius: 5px;
        }
        
        .promotions {
            background: rgba(0, 0, 0, 0.3);
            padding: 50px 0;
            margin: 50px 0;
        }
        
        .promo-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
        }
        
        .promo-cards {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 25px;
        }
        
        .promo-card {
            background: linear-gradient(135deg, #1a1a3a, #2a0a2a);
            border-radius: 10px;
            padding: 25px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.3);
            border: 1px solid rgba(255, 215, 0, 0.3);
        }
        
        .promo-card h3 {
            color: #ffd700;
            margin-bottom: 15px;
            font-size: 22px;
        }
        
        .promo-card p {
            margin-bottom: 20px;
            line-height: 1.5;
        }
        
        .btn-promo {
            background: transparent;
            color: #ffd700;
            border: 1px solid #ffd700;
            width: 100%;
        }
        
        footer {
            background: #0a0a2a;
            padding: 50px 0 20px;
        }
        
        .footer-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 30px;
        }
        
        .footer-column h3 {
            color: #ffd700;
            margin-bottom: 20px;
            font-size: 18px;
        }
        
        .footer-column ul {
            list-style: none;
        }
        
        .footer-column ul li {
            margin-bottom: 10px;
        }
        
        .footer-column ul li a {
            color: #ccc;
            text-decoration: none;
            transition: color 0.3s;
        }
        
        .footer-column ul li a:hover {
            color: #ffd700;
        }
        
        .copyright {
            text-align: center;
            margin-top: 40px;
            padding-top: 20px;
            border-top: 1px solid rgba(255, 255, 255, 0.1);
            color: #999;
            font-size: 14px;
        }
        
        @media (max-width: 768px) {
            .header-container {
                flex-direction: column;
            }
            
            nav ul {
                margin: 20px 0;
            }
            
            .hero h2 {
                font-size: 36px;
            }
            
            .hero p {
                font-size: 16px;
            }
        }
    </style>
</head>
<body>
    <!-- Шапка сайта -->
    <header>
        <div class="header-container">
            <div class="logo">
                <h1>ROYAL <span>CASINO</span></h1>
            </div>
            <nav>
                <ul>
                    <li><a href="#">Главная</a></li>
                    <li><a href="#">Игры</a></li>
                    <li><a href="#">Акции</a></li>
                    <li><a href="#">Турниры</a></li>
                    <li><a href="#">Поддержка</a></li>
                </ul>
            </nav>
            <div class="user-actions">
                <?php if(isset($_SESSION['user'])): ?>
                    <div class="user-info">
                        Добро пожаловать, <?php echo htmlspecialchars($_SESSION['user']['username']); ?>!
                        <div class="balance">Баланс: <span><?php echo number_format($_SESSION['user']['balance'], 0, '', ' '); ?> ₽</span></div>
                        <a href="logout.php" class="btn btn-logout">Выйти</a>
                    </div>
                <?php else: ?>
                    <div class="balance">Баланс: <span>10 000 ₽</span></div>
                    <button class="btn btn-login" onclick="showAuth()">Войти</button>
                    <button class="btn btn-register" onclick="showAuth()">Регистрация</button>
                <?php endif; ?>
            </div>
        </div>
    </header>

    <!-- Сообщения -->
    <?php if(isset($_SESSION['message'])): ?>
        <div class="message <?php echo $_SESSION['message_type']; ?>">
            <?php 
            echo $_SESSION['message'];
            unset($_SESSION['message']);
            unset($_SESSION['message_type']);
            ?>
        </div>
    <?php endif; ?>

    <!-- Главный баннер -->
    <section class="hero">
        <div class="hero-content">
            <h2>Королевские азартные игры</h2>
            <p>Ощутите атмосферу настоящего казино с нашими премиум играми. Более 100 игр, щедрые бонусы и круглосуточная поддержка.</p>
            <button class="btn btn-hero">Играть сейчас</button>
        </div>
    </section>

    <!-- Формы авторизации -->
    <?php if(!isset($_SESSION['user'])): ?>
    <section class="auth-section" id="authSection" style="display: none;">
        <div class="auth-tabs">
            <div class="auth-tab active" onclick="showTab('login')">Вход</div>
            <div class="auth-tab" onclick="showTab('register')">Регистрация</div>
        </div>
        
        <!-- Форма входа -->
        <form id="loginForm" class="auth-form active" method="POST" action="login.php">
            <div class="form-group">
                <label for="login_email">Email:</label>
                <input type="email" id="login_email" name="email" required>
            </div>
            <div class="form-group">
                <label for="login_password">Пароль:</label>
                <input type="password" id="login_password" name="password" required>
            </div>
            <button type="submit" class="btn btn-submit">Войти</button>
        </form>
        
        <!-- Форма регистрации -->
        <form id="registerForm" class="auth-form" method="POST" action="register.php">
            <div class="form-group">
                <label for="reg_username">Имя пользователя:</label>
                <input type="text" id="reg_username" name="username" required>
            </div>
            <div class="form-group">
                <label for="reg_email">Email:</label>
                <input type="email" id="reg_email" name="email" required>
            </div>
            <div class="form-group">
                <label for="reg_password">Пароль:</label>
                <input type="password" id="reg_password" name="password" required>
            </div>
            <div class="form-group">
                <label for="reg_confirm_password">Подтвердите пароль:</label>
                <input type="password" id="reg_confirm_password" name="confirm_password" required>
            </div>
            <button type="submit" class="btn btn-submit">Зарегистрироваться</button>
        </form>
    </section>
    <?php endif; ?>

    <!-- Раздел с играми -->
    <section class="games-section">
        <h2 class="section-title">Популярные игры</h2>
        <div class="games-grid">
            <!-- Игры... -->
            <div class="game-card">
                <div class="game-image" style="background-image: url('https://images.unsplash.com/photo-1595780259745-03193d5f2e4f?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80');"></div>
                <div class="game-info">
                    <h3 class="game-title">Классические слоты</h3>
                    <p class="game-description">Ощутите ностальгию с классическими игровыми автоматами. Простые правила и большие выигрыши!</p>
                    <button class="btn btn-play">Играть</button>
                </div>
            </div>
            
            <div class="game-card">
                <div class="game-image" style="background-image: url('https://images.unsplash.com/photo-1581089778245-3ce67677f718?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80');"></div>
                <div class="game-info">
                    <h3 class="game-title">Блэкджек</h3>
                    <p class="game-description">Классическая карточная игра против дилера. Наберите 21 очко и выиграйте крупный приз!</p>
                    <button class="btn btn-play">Играть</button>
                </div>
            </div>
            
            <div class="game-card">
                <div class="game-image" style="background-image: url('https://images.unsplash.com/photo-1515992854631-13de43ba2341?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80');"></div>
                <div class="game-info">
                    <h3 class="game-title">Рулетка</h3>
                    <p class="game-description">Испытайте удачу с европейской рулеткой. Сделайте ставку и наблюдайте за вращением колеса!</p>
                    <button class="btn btn-play">Играть</button>
                </div>
            </div>
            
            <div class="game-card">
                <div class="game-image" style="background-image: url('https://images.unsplash.com/photo-1615361200141-f45040f367be?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80');"></div>
                <div class="game-info">
                    <h3 class="game-title">Покер</h3>
                    <p class="game-description">Сыграйте в Техасский Холдем против реальных игроков. Стратегия и удача - ключ к успеху!</p>
                    <button class="btn btn-play">Играть</button>
                </div>
            </div>
        </div>
    </section>

    <!-- Раздел с акциями -->
    <section class="promotions">
        <div class="promo-container">
            <h2 class="section-title">Специальные предложения</h2>
            <div class="promo-cards">
                <div class="promo-card">
                    <h3>Приветственный бонус</h3>
                    <p>Получите 100% бонус на первый депозит до 10 000 ₽ и 100 бесплатных вращений в популярных слотах!</p>
                    <button class="btn btn-promo">Получить бонус</button>
                </div>
                
                <div class="promo-card">
                    <h3>Бездепозитный бонус</h3>
                    <p>Зарегистрируйтесь и получите 500 ₽ для игры без внесения депозита. Выигрыш ваш без ограничений!</p>
                    <button class="btn btn-promo">Получить бонус</button>
                </div>
                
                <div class="promo-card">
                    <h3>Кешбэк 10%</h3>
                    <p>Каждую неделю получайте 10% кешбэка от проигранных средств. Без ограничений по сумме!</p>
                    <button class="btn btn-promo">Подробнее</button>
                </div>
            </div>
        </div>
    </section>

    <!-- Подвал сайта -->
    <footer>
        <div class="footer-container">
            <div class="footer-column">
                <h3>О нас</h3>
                <ul>
                    <li><a href="#">О казино</a></li>
                    <li><a href="#">Лицензия</a></li>
                    <li><a href="#">Правила и условия</a></li>
                    <li><a href="#">Политика конфиденциальности</a></li>
                </ul>
            </div>
            
            <div class="footer-column">
                <h3>Игры</h3>
                <ul>
                    <li><a href="#">Слоты</a></li>
                    <li><a href="#">Настольные игры</a></li>
                    <li><a href="#">Карточные игры</a></li>
                    <li><a href="#">Живое казино</a></li>
                </ul>
            </div>
            
            <div class="footer-column">
                <h3>Поддержка</h3>
                <ul>
                    <li><a href="#">Часто задаваемые вопросы</a></li>
                    <li><a href="#">Служба поддержки</a></li>
                    <li><a href="#">Ответственная игра</a></li>
                    <li><a href="#">Заблокировать аккаунт</a></li>
                </ul>
            </div>
            
            <div class="footer-column">
                <h3>Контакты</h3>
                <ul>
                    <li>Телефон: 8-800-123-45-67</li>
                    <li>Email: support@royalcasino.ru</li>
                    <li>Круглосуточная поддержка</li>
                </ul>
            </div>
        </div>
        
        <div class="copyright">
            <p>© 2023 Royal Casino. Все права защищены. Азартные игры могут вызывать зависимость. Играйте ответственно.</p>
            <p>Лицензия №: 123456789 | Возрастное ограничение: 18+</p>
        </div>
    </footer>

    <script>
        function showAuth() {
            const authSection = document.getElementById('authSection');
            authSection.style.display = authSection.style.display === 'none' ? 'block' : 'none';
            if (authSection.style.display === 'block') {
                authSection.scrollIntoView({ behavior: 'smooth' });
            }
        }

        function showTab(tabName) {
            // Скрыть все формы
            document.querySelectorAll('.auth-form').forEach(form => {
                form.classList.remove('active');
            });
            
            // Убрать активный класс со всех вкладок
            document.querySelectorAll('.auth-tab').forEach(tab => {
                tab.classList.remove('active');
            });
            
            // Показать выбранную форму и активировать вкладку
            document.getElementById(tabName + 'Form').classList.add('active');
            event.target.classList.add('active');
        }

        // Проверка паролей при регистрации
        document.getElementById('registerForm')?.addEventListener('submit', function(e) {
            const password = document.getElementById('reg_password').value;
            const confirmPassword = document.getElementById('reg_confirm_password').value;
            
            if (password !== confirmPassword) {
                e.preventDefault();
                alert('Пароли не совпадают!');
            }
        });

        // Анимация кнопок
        document.querySelectorAll('.btn').forEach(button => {
            button.addEventListener('mouseenter', function() {
                this.style.transform = 'translateY(-2px)';
                this.style.boxShadow = '0 4px 8px rgba(0, 0, 0, 0.3)';
            });
            
            button.addEventListener('mouseleave', function() {
                this.style.transform = 'translateY(0)';
                this.style.boxShadow = 'none';
            });
        });

        // Игра
        document.querySelectorAll('.btn-play').forEach(button => {
            button.addEventListener('click', function() {
                const balanceElement = document.querySelector('.balance span');
                let balance = parseInt(balanceElement.textContent.replace(/\s/g, ''));
                const loss = Math.floor(Math.random() * 400) + 100;
                balance -= loss;
                balanceElement.textContent = balance.toString().replace(/\B(?=(\d{3})+(?!\d))/g, " ") + ' ₽';
                alert(`Вы проиграли ${loss} ₽. Удачи в следующий раз!`);
            });
        });
    </script>
</body>
</html>
