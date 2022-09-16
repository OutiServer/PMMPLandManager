-- #! mysql

-- # { economy
-- # { land
-- # { lands
-- # { init
CREATE TABLE IF NOT EXISTS lands
(
    id INTEGER PRIMARY KEY AUTO_INCREMENT,
    owner_xuid VARCHAR(16) DEFAULT NULL,
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
-- # }
-- # }
-- # }