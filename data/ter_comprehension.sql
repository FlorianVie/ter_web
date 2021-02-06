create table comprehension
(
    id_question int auto_increment
        primary key,
    question    text null,
    reponse     text null,
    type        text null
);

INSERT INTO ter.comprehension (id_question, question, reponse, type) VALUES (1, '80% des millennials interrogés au début de l’étude ont déclaré qu’être riche était un but important dans la vie.', 'Vrai', 'Littérale');
INSERT INTO ter.comprehension (id_question, question, reponse, type) VALUES (2, 'Tous les participants ont servi dans l’armée.', 'Faux', 'Inférencielle');
INSERT INTO ter.comprehension (id_question, question, reponse, type) VALUES (3, 'Robert Waldinger, le chercheur qui présente l’étude, est le 7ème directeur de l’étude.', 'Faux', 'Littérale');
INSERT INTO ter.comprehension (id_question, question, reponse, type) VALUES (4, 'Nous pouvons nous recréer des souvenirs.', 'Vrai', 'Inférencielle');
INSERT INTO ter.comprehension (id_question, question, reponse, type) VALUES (5, 'Un Américain sur sept déclare se sentir seul.', 'Faux', 'Littérale');
INSERT INTO ter.comprehension (id_question, question, reponse, type) VALUES (6, 'Le questionnaire est envoyé aux participants tous les deux ans.', 'Vrai', 'Littérale');
INSERT INTO ter.comprehension (id_question, question, reponse, type) VALUES (7, 'Le niveau de cholestérol à l’âge de 50 ans prédit la qualité la vie à 80 ans.', 'Faux', 'Littérale');
INSERT INTO ter.comprehension (id_question, question, reponse, type) VALUES (8, 'Les participants du groupe d’Harvard considère que leur vie est intéressante à étudier.', 'Vrai', 'Inférentielle');
INSERT INTO ter.comprehension (id_question, question, reponse, type) VALUES (9, 'Tous les adolescents ont été interviewés au commencement de l’étude.', 'Vrai', 'Inférentielle');
INSERT INTO ter.comprehension (id_question, question, reponse, type) VALUES (10, '120 participants sont toujours en vie et continuent de prendre part à l’étude.', 'Faux', 'Littérale');
INSERT INTO ter.comprehension (id_question, question, reponse, type) VALUES (11, 'Le 1er groupe de participants était constitué d’étudiants en 1ère année à l’université d’Harvard.', 'Faux', 'Inférentielle');
INSERT INTO ter.comprehension (id_question, question, reponse, type) VALUES (12, 'Plus le nombre de relation est élevé, meilleure est la santé des participants.', 'Faux', 'Inférentielle');
INSERT INTO ter.comprehension (id_question, question, reponse, type) VALUES (13, 'Les gens qui ont été les plus satisfaits dans leurs relations à 50 ans étaient ceux en meilleure santé à 80 ans.', 'Vrai', 'Littérale');
INSERT INTO ter.comprehension (id_question, question, reponse, type) VALUES (14, 'Les épouses ont été incluses dans l’étude au moment de leur mariage.', 'Faux', 'Inférentielle');
INSERT INTO ter.comprehension (id_question, question, reponse, type) VALUES (15, 'Les participants vivant une relation conjugale chaleureuse ont rapporté ne pas ressentir de douleur physique.', 'Faux', 'Inférentielle');
INSERT INTO ter.comprehension (id_question, question, reponse, type) VALUES (16, 'Les études longitudinales sont difficiles à mettre en place.', 'Vrai', 'Inférentielle');