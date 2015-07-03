SELECT owner.name, car.make, car.model
FROM Owner
INNER JOIN Car
WHERE Owner.age BETWEEN 50 AND 59;
