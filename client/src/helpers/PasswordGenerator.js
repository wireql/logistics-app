const length = 6;
const includeNumbers = true;

const generatePassword = () => {
    let chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    if (includeNumbers) chars += '0123456789';
    
    return Array.from({ length: length }, () =>
        chars.charAt(Math.floor(Math.random() * chars.length))
    ).join('');
};

export default generatePassword;