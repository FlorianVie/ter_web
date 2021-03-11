library(psych)
library(dplyr)


# Chi²

chi_conf <- read.csv("data/chi_conf.csv", row.names = 1, header = T)
chi_conf
chisq.test(as.numeric(chi_conf[1,]), p=as.numeric(chi_conf[2,]))

chi_hom <- read.csv(("data/chi_hom.csv"), row.names = 1, header = T)
chi_hom
chisq.test(chi_hom)

# --------------
# Correlation
#---------------

correlation <- read.csv("data/corr.csv", row.names = 1, header = T)
summary(correlation)
cor.test(correlation$Stress_percu, correlation$Depression)

cor(correlation)


# --------------
# T Test
#---------------

ttest <- read.csv("data/t_test.csv", header = T)
summary(ttest)
boxplot(ttest)
t.test(ttest$Olders, ttest$MA)


