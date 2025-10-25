let currentUser = null;
let balance = 0;
let rouletteCurrentBet = null;
let blackjackGame = null;

// Функции авторизации
function showRegister() {
    document.querySelector('.auth-form').style.display = 'none';
    document.getElementById('register-form').style.display = 'block';
}

function showLogin() {
    document.querySelector('.auth-form').style.display = 'block';
    document.getElementById('register-form').style.display = 'none';
}

function register() {
    const username = document.getElementById('reg-username').value;
    const password = document.getElementById('reg-password').value;

    if (!username || !password) {
        alert('Заполните все поля!');
        return;
    }

    // Чтение существующих пользователей
    const users = readUsers();
    
    // Проверка на существующего пользователя
    if (users.find(u => u.username === username)) {
        alert('Пользователь уже существует!');
        return;
    }

    // Добавление нового пользователя
    users.push({
        username: username,
        password: password,
        balance: 10000
    });

    writeUsers(users);
    alert('Регистрация успешна! Теперь войдите в систему.');
    showLogin();
}

function login() {
    const username = document.getElementById('login-username').value;
    const password = document.getElementById('login-password').value;

    const users = readUsers();
    const user = users.find(u => u.username === username && u.password === password);

    if (user) {
        currentUser = user.username;
        balance = user.balance;
        startSession();
    } else {
        alert('Неверное имя пользователя или пароль!');
    }
}

function logout() {
    currentUser = null;
    balance = 0;
    document.getElementById('auth-section').style.display = 'block';
    document.getElementById('casino-section').style.display = 'none';
}

function startSession() {
    document.getElementById('auth-section').style.display = 'none';
    document.getElementById('casino-section').style.display = 'block';
    document.getElementById('username-display').textContent = currentUser;
    updateBalance();
}

// Работа с файлом пользователей
function readUsers() {
    // В реальном проекте здесь был бы AJAX запрос к серверу
    // Для демонстрации используем localStorage
    const usersData = localStorage.getItem('casinoUsers');
    return usersData ? JSON.parse(usersData) : [];
}

function writeUsers(users) {
    // В реальном проекте здесь был бы AJAX запрос к серверу
    localStorage.setItem('casinoUsers', JSON.stringify(users));
}

function updateBalance() {
    document.getElementById('balance').textContent = balance.toLocaleString();
    
    // Обновляем баланс в "базе данных"
    const users = readUsers();
    const userIndex = users.findIndex(u => u.username === currentUser);
    if (userIndex !== -1) {
        users[userIndex].balance = balance;
        writeUsers(users);
    }
}

// Игры
function playSlots() {
    const bet = parseInt(document.getElementById('slot-bet').value);
    const resultElement = document.getElementById('slot-result');

    if (!bet || bet <= 0) {
        resultElement.textContent = 'Введите корректную ставку!';
        resultElement.className = 'message lose';
        return;
    }

    if (bet > balance) {
        resultElement.textContent = 'Недостаточно средств!';
        resultElement.className = 'message lose';
        return;
    }

    // Анимация слотов
    spinSlots();

    setTimeout(() => {
        const symbols = ['🍒', '🍋', '🍊', '🍇', '🔔', '💎'];
        const slot1 = symbols[Math.floor(Math.random() * symbols.length)];
        const slot2 = symbols[Math.floor(Math.random() * symbols.length)];
        const slot3 = symbols[Math.floor(Math.random() * symbols.length)];

        document.getElementById('slot1').textContent = slot1;
        document.getElementById('slot2').textContent = slot2;
        document.getElementById('slot3').textContent = slot3;

        let winAmount = 0;
        let message = '';

        if (slot1 === slot2 && slot2 === slot3) {
            // Джекпот - три одинаковых символа
            winAmount = bet * 10;
            message = `ДЖЕКПОТ! Вы выиграли $${winAmount}!`;
        } else if (slot1 === slot2 || slot2 === slot3 || slot1 === slot3) {
            // Два одинаковых символа
            winAmount = bet * 3;
            message = `Поздравляем! Вы выиграли $${winAmount}!`;
        } else {
            winAmount = -bet;
            message = 'Повезет в следующий раз!';
        }

        balance += winAmount;
        updateBalance();

        resultElement.textContent = message;
        resultElement.className = 'message ' + (winAmount > 0 ? 'win' : 'lose');
    }, 1000);
}

function spinSlots() {
    const symbols = ['🍒', '🍋', '🍊', '🍇', '🔔', '💎'];
    let spins = 0;
    const maxSpins = 10;
    const interval = setInterval(() => {
        document.getElementById('slot1').textContent = symbols[Math.floor(Math.random() * symbols.length)];
        document.getElementById('slot2').textContent = symbols[Math.floor(Math.random() * symbols.length)];
        document.getElementById('slot3').textContent = symbols[Math.floor(Math.random() * symbols.length)];
        spins++;
        if (spins >= maxSpins) {
            clearInterval(interval);
        }
    }, 100);
}

function placeRouletteBet(type) {
    rouletteCurrentBet = type;
    document.querySelectorAll('.roulette-bets button').forEach(btn => btn.style.opacity = '0.5');
    event.target.style.opacity = '1';
}

function spinRoulette() {
    const betAmount = parseInt(document.getElementById('roulette-bet').value);
    const resultElement = document.getElementById('roulette-result');

    if (!rouletteCurrentBet) {
        resultElement.textContent = 'Сделайте ставку!';
        resultElement.className = 'message lose';
        return;
    }

    if (!betAmount || betAmount <= 0) {
        resultElement.textContent = 'Введите корректную ставку!';
        resultElement.className = 'message lose';
        return;
    }

    if (betAmount > balance) {
        resultElement.textContent = 'Недостаточно средств!';
        resultElement.className = 'message lose';
        return;
    }

    // Генерация случайного числа рулетки (0-36)
    const number = Math.floor(Math.random() * 37);
    const isRed = [1,3,5,7,9,12,14,16,18,19,21,23,25,27,30,32,34,36].includes(number);
    const isBlack = [2,4,6,8,10,11,13,15,17,20,22,24,26,28,29,31,33,35].includes(number);
    const isGreen = number === 0;

    document.getElementById('roulette-number').textContent = number;
    document.getElementById('roulette-number').style.color = isRed ? '#ff4444' : isBlack ? '#000' : '#00aa00';

    let winAmount = 0;
    let message = '';

    if ((rouletteCurrentBet === 'red' && isRed) ||
        (rouletteCurrentBet === 'black' && isBlack) ||
        (rouletteCurrentBet === 'green' && isGreen)) {
        
        const multiplier = rouletteCurrentBet === 'green' ? 14 : 2;
        winAmount = betAmount * multiplier - betAmount;
        message = `Вы выиграли $${winAmount + betAmount}!`;
    } else {
        winAmount = -betAmount;
        message = 'Ставка проиграна!';
    }

    balance += winAmount;
    updateBalance();

    resultElement.textContent = message;
    resultElement.className = 'message ' + (winAmount > 0 ? 'win' : 'lose');
}

// Блэкджек
function startBlackjack() {
    const betAmount = parseInt(document.getElementById('blackjack-bet').value);

    if (!betAmount || betAmount <= 0) {
        showBlackjackResult('Введите корректную ставку!', 'lose');
        return;
    }

    if (betAmount > balance) {
        showBlackjackResult('Недостаточно средств!', 'lose');
        return;
    }

    blackjackGame = {
        bet: betAmount,
        playerCards: [],
        dealerCards: [],
        playerScore: 0,
        dealerScore: 0,
        gameOver: false
    };

    // Раздача начальных карт
    blackjackGame.playerCards = [drawCard(), drawCard()];
    blackjackGame.dealerCards = [drawCard(), drawCard()];

    balance -= betAmount;
    updateBalance();

    updateBlackjackDisplay();
    document.querySelectorAll('#blackjack-controls button')[0].style.display = 'none';
    document.querySelectorAll('#blackjack-controls button')[1].style.display = 'inline-block';
    document.querySelectorAll('#blackjack-controls button')[2].style.display = 'inline-block';
}

function hit() {
    if (!blackjackGame || blackjackGame.gameOver) return;

    blackjackGame.playerCards.push(drawCard());
    updateBlackjackDisplay();

    if (calculateScore(blackjackGame.playerCards) > 21) {
        stand();
    }
}

function stand() {
    if (!blackjackGame || blackjackGame.gameOver) return;

    blackjackGame.gameOver = true;

    // Дилер берет карты до 17
    while (calculateScore(blackjackGame.dealerCards) < 17) {
        blackjackGame.dealerCards.push(drawCard());
    }

    const playerScore = calculateScore(blackjackGame.playerCards);
    const dealerScore = calculateScore(blackjackGame.dealerCards);

    let winAmount = 0;
    let message = '';

    if (playerScore > 21) {
        message = 'Перебор! Вы проиграли.';
        winAmount = 0;
    } else if (dealerScore > 21) {
        message = 'Дилер перебрал! Вы выиграли!';
        winAmount = blackjackGame.bet * 2;
    } else if (playerScore > dealerScore) {
        message = 'Вы выиграли!';
        winAmount = blackjackGame.bet * 2;
    } else if (playerScore === dealerScore) {
        message = 'Ничья! Ставка возвращена.';
        winAmount = blackjackGame.bet;
    } else {
        message = 'Дилер выиграл!';
        winAmount = 0;
    }

    balance += winAmount;
    updateBalance();

    showBlackjackResult(message, winAmount > blackjackGame.bet ? 'win' : 'lose');
    
    // Показываем все карты дилера
    updateBlackjackDisplay(true);
    
    document.querySelectorAll('#blackjack-controls button')[0].style.display = 'inline-block';
    document.querySelectorAll('#blackjack-controls button')[1].style.display = 'none';
    document.querySelectorAll('#blackjack-controls button')[2].style.display = 'none';
}

function drawCard() {
    const cards = ['2', '3', '4', '5', '6', '7', '8', '9', '10', 'J', 'Q', 'K', 'A'];
    return cards[Math.floor(Math.random() * cards.length)];
}

function calculateScore(cards) {
    let score = 0;
    let aces = 0;

    for (let card of cards) {
        if (card === 'A') {
            aces++;
            score += 11;
        } else if (['K', 'Q', 'J'].includes(card)) {
            score += 10;
        } else {
            score += parseInt(card);
        }
    }

    // Обработка тузов
    while (score > 21 && aces > 0) {
        score -= 10;
        aces--;
    }

    return score;
}

function updateBlackjackDisplay(showDealerCards = false) {
    const cardsElement = document.getElementById('blackjack-cards');
    cardsElement.innerHTML = '';

    // Карты игрока
    cardsElement.innerHTML += '<p>Ваши карты:</p>';
    blackjackGame.playerCards.forEach(card => {
        cardsElement.innerHTML += `<div class="card">${card}</div>`;
    });
    cardsElement.innerHTML += `<p>Счет: ${calculateScore(blackjackGame.playerCards)}</p>`;

    // Карты дилера
    cardsElement.innerHTML += '<p>Карты дилера:</p>';
    blackjackGame.dealerCards.forEach((card, index) => {
        if (showDealerCards || index === 0) {
            cardsElement.innerHTML += `<div class="card">${card}</div>`;
        } else {
            cardsElement.innerHTML += `<div class="card">?</div>`;
        }
    });
    
    if (showDealerCards) {
        cardsElement.innerHTML += `<p>Счет дилера: ${calculateScore(blackjackGame.dealerCards)}</p>`;
    }
}

function showBlackjackResult(message, type) {
    const resultElement = document.getElementById('blackjack-result');
    resultElement.textContent = message;
    resultElement.className = 'message ' + type;
}

// Инициализация
document.getElementById('login-password').addEventListener('keypress', function(e) {
    if (e.key === 'Enter') login();
});

document.getElementById('reg-password').addEventListener('keypress', function(e) {
    if (e.key === 'Enter') register();
});
