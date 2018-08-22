---create--


create table if not exists pelada (
id_pelada int not null primary key auto_increment,
nome varchar(150) not null,
descricao text null,
duracao_pelada time,
qt_jogadores int (2),
sorteio tinyint,
data_pelada datetime,
data_criacao datetime ,
fk_peladeiro int(11) not null,
fk_localizacao int(11)
);


create table if not exists peladeiro (
id_peladeiro int (11) not null primary key auto_increment,
nome varchar(150) not null,
email varchar(60) not null,
telefone varchar(15) null,
url_imagem varchar(150) null,
participacao tinyint,
fk_usuario int(11) not null,
fk_marcacoes int (11) null,
fk_time_partida int(11) null
);
create table if not exists usuario (
id_usuario int (11) not null primary key auto_increment,
nome varchar (150) not null,
email varchar (60) not null,
apelido varchar (60) null,
senha varchar (255) not null,
sexo char(2) null,
url_imagem varchar(150) null,
ativo tinyint default 1,
data_criacao datetime
);

create table if not exists privilegios (
id_privilegios int (11) not null primary key auto_increment,
tipo varchar(40) not null
);

create table if not exists usuario_privilegio (
id_privilegio_usuario int (11) not null auto_increment primary key,
fk_usuario int(11) not null,
fk_privilegio int (11) not null
);

create table if not exists time_partida (
id_time_partida int (11) not null primary key auto_increment,
nome varchar (150) not null,
fk_pelada int not null
);

create table if not exists partida (
id_partida int (11) not null auto_increment primary key,
primeiro_time varchar (60),
segundo_time varchar (60)
);

create table if not exists peladeiro_time (
id_peladeiro_time int (11) not null primary key auto_increment,
fk_peladeiro int(11) not null,
fk_time_partida int(11) not null
);

create table if not exists marcacao (
id_marcacao int (11) not null auto_increment primary key,
fk_tipo_marcacao varchar(60),
hora time,
fk_time_partida int(11) not null,
fk_partida int (11) not null
);

create table if not exists tipo_marcacao (
id_tipo_marcacao int(11) not null primary key auto_increment,
nome varchar(60) not null
);

create table if not exists time_futebol (
id_time_futebol int (11) not null primary key auto_increment,
nome varchar(60) not null
);

create table if not exists posicao_peladeiro (
id_posicao_peladeiro int (11) not null auto_increment primary key,
nome varchar(60)
);

create table if not exists estado (
id_estado int (11) not null primary key auto_increment,
nome varchar(60) not null,
sigla char(2) not null
);

create table if not exists cidade (
id_cidade int(11) not null primary key auto_increment,
nome varchar(250) not null,
fk_estado int(11) not null
);

create table if not exists localizacao_pelada (
id_localizacao_pelada int(11) not null primary key auto_increment,
rua varchar(250) not null,
bairro varchar (150) not null,
numero int(4),
fk_cidade int(11) not null
);

---Alter---
alter table pelada 
add constraint fkpeladeiro foreign key (fk_peladeiro) references peladeiro(id_peladeiro),
add constraint fklocalizacao foreign key (fk_localizacao) references localizacao_pelada(id_localizacao_pelada);

alter table cidade
add constraint fkestado foreign key (fk_estado) references estado(id_estado);

alter table localizacao_pelada
add constraint fkcidade foreign key (fk_cidade) references cidade(id_cidade);

alter table time_partida
add constraint fkpelada foreign key (fk_pelada) references pelada(id_pelada);

alter table marcacao
add constraint fkpartida1 foreign key (fk_partida) references partida(id_partida),
add constraint fktimepartida foreign key (fk_time_partida) references time_partida(id_time_partida),
add constraint fktipomarcacao foreign key (fk_tipo_marcacao) references tipo_marcacao(id_tipo_marcacao);

alter table peladeiro_time
add constraint fkpeladeiro foreign key (fk_peladeiro) references peladeiro(id_peladeiro),
add constraint fktimepartida foreign key (fk_time_partida) references time_partida(id_time_partida);

alter table usuario_privilegio
add constraint fkusuario foreign key (fk_usuario) references usuario(id_usuario),
add constraint fkprivilegio foreign key (fk_privilegio) references privilegios(id_privilegio);

alter table peladeiro
add constraint fkusuario foreign key (fk_usuario) references usuario(id_usuario),
add constraint fkmarcacao foreign key (fk_marcacoes) references marcacao(id_marcacao),
add constraint fktimefutebol foreign key (fk_time_futebol) references time_futebol(id_time_futebol);