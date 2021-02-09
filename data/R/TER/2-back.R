library(tidyverse)
library(RMariaDB)
library(rbokeh)

data_raw_2 <- read.csv2("http://ter.bigfive.890m.com/2-back.csv", sep = ",")

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

accuracy$id_subject <- as.character(accuracy$id_subject)

ggplot(data = accuracy) +
  geom_line(aes(id_2_back, mean_correct, color = id_subject)) +
  expand_limits(x = 0, y = 0) +
  theme_bw()







