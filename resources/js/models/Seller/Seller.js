export const createSeller = ({
    id = Number(),
    avatar = String(),
    name = String(),
    remaining_points = Number(),
    total_points = Number(),
    winning_points = Number(),
}) => ({
    id,
    avatar,
    name,
    total_points,
    remaining_points,
    winning_points
});
