-- Order Management Triggers

-- After Order Insert Trigger
DROP TRIGGER IF EXISTS after_order_insert;

CREATE TRIGGER after_order_insert
AFTER INSERT ON tblorders
FOR EACH ROW
BEGIN
    UPDATE tbluser 
    SET reward_points = reward_points + NEW.reward_points_earned - NEW.reward_points_used
    WHERE Id = NEW.user_id;
    
    INSERT INTO reward_point_history (user_id, message)
    VALUES (NEW.user_id, CONCAT('Your order #', NEW.order_id, ' has been placed successfully. You earned ', NEW.reward_points_earned, ' reward points!'));
END;

-- Appointment Management Triggers
DROP TRIGGER IF EXISTS after_appointment_cancel;

CREATE TRIGGER after_appointment_cancel
AFTER UPDATE ON tblappointments
FOR EACH ROW
BEGIN
    IF NEW.status = 'Cancelled' AND OLD.status != 'Cancelled' THEN
        INSERT INTO reward_point_history (user_id, appointment_id, message)
        VALUES (NEW.user_id, NEW.id, 
            CONCAT('Your appointment has been cancelled. Your payment of ', 
                   NEW.amount_paid, ' Taka will be refunded within 24 hours.'));
                   
        IF OLD.payment_method = 'reward_points' THEN
            UPDATE tbluser 
            SET reward_points = reward_points + OLD.amount_paid
            WHERE Id = OLD.user_id;
        END IF;
    END IF;
END;

-- Product Price History Trigger
CREATE TABLE IF NOT EXISTS product_price_history (
    id INT PRIMARY KEY AUTO_INCREMENT,
    product_id INT,
    old_price DECIMAL(10,2),
    new_price DECIMAL(10,2),
    changed_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (product_id) REFERENCES tblproduct(Id)
);

DROP TRIGGER IF EXISTS before_product_update;

CREATE TRIGGER before_product_update
BEFORE UPDATE ON tblproduct
FOR EACH ROW
BEGIN
    IF NEW.Pprice != OLD.Pprice THEN
        INSERT INTO product_price_history (product_id, old_price, new_price)
        VALUES (OLD.Id, OLD.Pprice, NEW.Pprice);
    END IF;
END; 