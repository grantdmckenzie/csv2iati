create table models (
  username varchar(255),
  map text,
  filename varchar(255),
  ts timestamp default current_timestamp,
  modelname varchar(255)
 )