library(tidyverse)

rspan_raw <- read.csv2('retran_rspan.csv', sep = ',')
rspan_raw$rt <- as.numeric(rspan_raw$rt)

recall <- rspan_raw %>%
  filter(part != 'sentence-pre') %>%
  filter(part != 'sentence-post') %>%
  group_by(subject_id, part) %>%
  summarise(
    correct_sum = sum(correct),
    rt_mean = mean(rt)
  )

sentences <- rspan_raw %>%
  filter(part != 'recall-pre') %>%
  filter(part != 'recall-post') %>%
  group_by(subject_id, part) %>%
  summarise(
    correct_sum = sum(correct),
    rt_mean = mean(rt)
  )







