CREATE TABLE USERS
(
    user_id varchar NOT NULL,
    user_name varchar NOT NULL,
    user_password varchar NOT NULL,
    created_at timestamp,
    updated_at timestamp,
    CONSTRAINT pk PRIMARY KEY (user_id)
)