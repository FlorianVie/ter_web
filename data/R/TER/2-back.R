library(tidyverse)
library(RMariaDB)
library(rbokeh)

# Connection BDD
pw <- "Empereur1"
storiesDb <- dbConnect(RMariaDB::MariaDB(), user='u485051925_experi', password=pw, dbname='u485051925_ter', host='sql200.main-hosting.eu')
query <- paste("SELECT * FROM back_2")
print(query)
rs = dbSendQuery(storiesDb,query)
data_raw_2 <- dbFetch(rs)

data_raw_2$id_subject <- as.character(data_raw_2$id_subject)

data_2 <- data_raw_2 %>%
  filter(part == "2-back") %>%
  filter(is_target == 1)

data_2_mean <- data_2 %>%
  group_by(id_subject, id_2_back, is_target) %>%
  summarise(
    mean_correct = mean(correct)
  )

p <- figure(width = 800) %>%
  ly_points(data_2_mean$id_2_back, data_2_mean$mean_correct, color = data_2_mean$id_subject) %>%
  ly_lines(data_2_mean$id_2_back, data_2_mean$mean_correct, color = data_2_mean$id_subject)
p














