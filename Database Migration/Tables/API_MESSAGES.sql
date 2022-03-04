
CREATE TABLE API_MESSAGES
(
    id VARCHAR NOT NULL,
    user_id VARCHAR NOT NULL,
    caller VARCHAR,
    response VARCHAR,
    created_at TIMESTAMP,
    updated_at TIMESTAMP,
    CONSTRAINT pk_api_msgs PRIMARY KEY (id, user_id)
)