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

async function checkPatientAccess(token, patientCardId) {
    try {
        const response = await fetch(`http://localhost:3003/api/users/check/${patientCardId}`, {
            headers: { Authorization: `Bearer ${token}` }
        });

        if (response.status === 403) {
            alert('У вас нет доступа к этой карте пациента.');
            if (document.referrer) {
                window.location.href = document.referrer; // Возвращает на предыдущую страницу
            } else {
                window.location.href = '/index.php'; // Перенаправляет на страницу авторизации
            }
            return false;
        }

        return true;
    } catch (error) {
        console.error('Ошибка проверки доступа:', error);
        alert('Ошибка при проверке доступа. Попробуйте снова.');
        return false;
    }
}


// Экспортируем функции для использования в других файлах
export { checkPatientAccess, getToken, parseJwt };


