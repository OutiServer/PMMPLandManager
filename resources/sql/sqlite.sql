-- #! sqlite

-- # { economy
-- # { land
-- # { lands
-- # { init
CREATE TABLE IF NOT EXISTS lands
(
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    owner_xuid TEXT DEFAULT NULL,
    price INTEGER NOT NULL,
    world_name TEXT NOT NULL,
    start_x INTEGER NOT NULL,
    start_y INTEGER NOT NULL,
    start_z INTEGER NOT NULL,
    end_x INTEGER NOT NULL,
    end_y INTEGER NOT NULL,
    end_z INTEGER NOT NULL,
    signboard_x INTEGER NOT NULL,
    signboard_y INTEGER NOT NULL,
    signboard_z INTEGER NOT NULL
);
-- # }

-- # { create
-- #    :price int
-- #    :world_name string
-- #    :start_x int
-- #    :start_y int
-- #    :start_z int
-- #    :end_x int
-- #    :end_y int
-- #    :end_z int
-- #    :signboard_x int
-- #    :signboard_y int
-- #    :signboard_z int
INSERT INTO lands (price, world_name, start_x, start_y, start_z, end_x, end_y, end_z, signboard_x, signboard_y, signboard_z) VALUES (:price, :world_name, :start_x, :start_y, :start_z, :end_x, :end_y, :end_z, :signboard_x, :signboard_y, :signboard_z);
-- # }

-- # { seq
SELECT seq FROM sqlite_sequence WHERE name = 'mails';
-- # }

-- # { load
SELECT * FROM lands;
-- # }

-- # { update
-- #    :owner_xuid ?string
-- #    :price int
-- #    :id int
UPDATE lands SET owner_xuid = :owner_xuid, price = :price WHERE id = :id;
-- # }

-- # { delete
-- #    :id int
DELETE FROM lands WHERE id = :id;
-- # }

-- # { drop
DROP TABLE lands;
-- # }

-- # }
-- # }
-- # }