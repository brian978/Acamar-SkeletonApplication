-- -------------------------------
-- Table structure for publishers
-- -------------------------------
CREATE TABLE IF NOT EXISTS publishers (
  id INTEGER CONSTRAINT publishers_pKey PRIMARY KEY AUTOINCREMENT,
  "name" VARCHAR(255) NOT NULL
);
