library(tidyverse)
library(RMariaDB)

# Connection BDD
pw <- "Empereur1"
storiesDb <- dbConnect(RMariaDB::MariaDB(), user='u485051925_experi', password=pw, dbname='u485051925_ter', host='sql200.main-hosting.eu')
query <- paste("SELECT * FROM data")
print(query)
rs = dbSendQuery(storiesDb,query)
data_raw <- dbFetch(rs)


data_raw$rt <- as.numeric(data_raw$rt)
data_raw$correct <- as.numeric(data_raw$correct)

sentences <- data_raw %>%
  filter(part == "sentence")

sentences_desc <- sentences %>%
  group_by(subject, make_sense) %>%
  summarise(
    rt_mean = mean(rt, na.rm = TRUE),
    correct_mean = mean(correct, na.rm = TRUE)
  )

recall <- data_raw %>%
  filter(part == "recall")

recall_desc <- recall %>%
  group_by(subject) %>%
  summarise(
    rt_mean = mean(rt, na.rm = TRUE),
    correct_mean = mean(correct, na.rm = TRUE)
  )
















