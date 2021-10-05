export const createSeller = ({
    id = Number(),
    avatar = String(),
    name = String(),
    total_points = Number(),
}) => ({
    id,
    avatar,
    name,
    total_points,
});
