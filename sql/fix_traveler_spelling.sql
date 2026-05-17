-- One-off migration: standardise on 'Traveller' (two Ls).
-- Run once against u24611400_Tripistry to fix an existing local/Wheatley DB.
-- After running, the column accepts only 'Agency' and 'Traveller'.

-- Step 1: widen enum so both spellings are valid temporarily
ALTER TABLE `users`
    MODIFY COLUMN `Type` ENUM('Agency', 'Traveler', 'Traveller') NOT NULL;

-- Step 2: migrate any existing 'Traveler' rows (seed data) over
UPDATE `users`
SET `Type` = 'Traveller'
WHERE `Type` = 'Traveler';

-- Step 3: narrow enum back to just the canonical spellings
ALTER TABLE `users`
    MODIFY COLUMN `Type` ENUM('Agency', 'Traveller') NOT NULL;

-- Verify
SELECT `User_ID`, `Name`, `Email`, `Type` FROM `users`;
