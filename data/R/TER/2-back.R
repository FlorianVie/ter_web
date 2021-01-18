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
  filter(part == "2-back")

data_2_mean <- data_2 %>%
  group_by(id_subject, id_2_back, is_target) %>%
  summarise(
    mean_correct = mean(correct)
  )

hits <- data_2_mean %>%
  filter(is_target == 1)

false_alarm <- data_2_mean %>%
  filter(is_target == 0)
false_alarm$mean_correct = 1 - false_alarm$mean_correct

accuracy <- hits
accuracy$mean_correct <- hits$mean_correct - false_alarm$mean_correct



# Plots   

acc <- figure(width = 800) %>%
  ly_points(accuracy$id_2_back, accuracy$mean_correct, color = accuracy$id_subject) %>%
  ly_lines(accuracy$id_2_back, accuracy$mean_correct, color = accuracy$id_subject)
acc










