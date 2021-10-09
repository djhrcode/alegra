export const createNotificationsState = ({
    items = Array(),
    delay = 3000,
}) => ({ items, delay });

export const createNotificationId = () =>
    Math.floor(Math.random() * Date.now());

export const createNotification = ({
    id = Number(),
    title = String(),
    message = String(),
    color = "primary",
    isLight = false,
    delay = Number(3000)
}) => ({ id: id || createNotificationId(), title, message, color, isLight, delay });
