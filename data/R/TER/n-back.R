library(tidyverse)
library(RMariaDB)

# Connection BDD
pw <- "Empereur1"
storiesDb <- dbConnect(RMariaDB::MariaDB(), user='u485051925_experi', password=pw, dbname='u485051925_ter', host='sql200.main-hosting.eu')
query <- paste("SELECT * FROM back_1")
print(query)
rs = dbSendQuery(storiesDb,query)
data_raw_1 <- dbFetch(rs)

data_1 <- data_raw_1 %>%
  filter(part == "1-back")

data_1_mean <- data_1 %>%
  group_by(id_subject, id_1_back, is_target) %>%
  summarise(
    mean_correct = mean(correct)
    )

