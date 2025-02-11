// Функция получения токена из cookies
function getToken() {
    const cookies = document.cookie.split('; ');
    const tokenCookie = cookies.find(row => row.startsWith('token='));
    return tokenCookie ? tokenCookie.split('=')[1] : null;
}

// Функция декодирования JWT-токена
function parseJwt(token) {
    try {
        return JSON.parse(atob(token.split('.')[1])); // Декодируем payload токена
    } catch (e) {
        return null;
    }
}

// Экспортируем функции для использования в других файлах
export { getToken, parseJwt };
