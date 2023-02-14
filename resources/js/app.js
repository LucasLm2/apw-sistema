import './bootstrap';

import swal from 'sweetalert';

import Inputmask from "inputmask";

import excluir from './funcoes/excluir';
window.excluir = excluir;

import inativar from './funcoes/inativar';
window.inativar = inativar;

import ativar from './funcoes/ativar';
window.ativar = ativar;

import adicionarMascara from './funcoes/adicionar-mascara';
window.adicionarMascara = adicionarMascara;

import * as pesquisa from './preencherCep';
window.pesquisaCep = pesquisa.pesquisaCep;
window.buscarMunicipios = pesquisa.buscarMunicipios;