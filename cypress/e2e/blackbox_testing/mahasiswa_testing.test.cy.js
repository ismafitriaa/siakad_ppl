/// <reference types="cypress" />

describe('User can Open Mahasiswa List Page', () => {
    it('Index Mahasiswa List', () => {
        cy.visit("http://127.0.0.1:8000/mahasiswa");
        cy.get('h2').should('have.text','JURUSAN TEKNOLOGI INFORMASI-POLITEKNIK NEGERI MALANG');
        cy.get('tbody > :nth-child(1) > :nth-child(1)').should('have.text','Nim');
        cy.get('tbody > :nth-child(1) > :nth-child(2)').should('have.text','Nama');
        cy.get('tbody > :nth-child(1) > :nth-child(3)').should('have.text','Kelas');
        cy.get('tbody > :nth-child(1) > :nth-child(4)').should('have.text','Jurusan');
        cy.get('[width="280px"]').should('have.text','Action');
    });
    it('Create Mahasiswa List', () => {
        cy.visit("http://127.0.0.1:8000/mahasiswa");
        cy.get('.float-right > .btn').click();
        cy.get('.card-header').contains('Tambah Mahasiswa').and('be.visible');
        cy.get(':nth-child(2) > label').should('have.text','Nim');
        cy.get(':nth-child(3) > label').should('have.text','Nama');
        cy.get(':nth-child(4) > label').should('have.text','Kelas');
        cy.get(':nth-child(5) > label').should('have.text','Jurusan');
        cy.get('#Nim').type("2041728639",{force:true});
        cy.get('#Nama').type("Isma Fitria Risnandari",{force:true});
        cy.get('#Kelas').type("TI - 3G",{force:true});
        cy.get('#Jurusan').type("Teknologi Informasi",{force:true});
        cy.get('.btn').contains("Submit").and("be.enabled");
    });
    it('Show Mahasiswa List', () => {
        cy.visit("http://127.0.0.1:8000/mahasiswa");
        cy.get(':nth-child(2) > :nth-child(5) > form > .btn-info').click();
        cy.get('.card-header').contains('Detail Mahasiswa').and('be.visible');
        cy.get('.list-group > :nth-child(1)').contains('Nim').and('be.visible');
        cy.get('.list-group > :nth-child(2)').contains('Nama').and('be.visible');
        cy.get('.list-group > :nth-child(3)').contains('Kelas').and('be.visible');
        cy.get('.list-group > :nth-child(4)').contains('Jurusan').and('be.visible');
        cy.get('.btn').click({ force: true });
    });
    it('Edit Mahasiswa List', () => {
        cy.visit("http://127.0.0.1:8000/mahasiswa");
        cy.get(':nth-child(2) > :nth-child(5) > form > .btn-primary').click();
        cy.get('.card-header').contains('Edit Mahasiswa').and('be.visible');
        cy.get(':nth-child(3) > label').should('have.text','Nim');
        cy.get(':nth-child(4) > label').should('have.text','Nama');
        cy.get(':nth-child(5) > label').should('have.text','Kelas');
        cy.get(':nth-child(6) > label').should('have.text','Jurusan');
        cy.get('#Nim').type("2041728689",{force:true});
        cy.get('#Nama').type("Zenaa",{force:true});
        cy.get('#Kelas').type("TI - 4G",{force:true});
        cy.get('#Jurusan').type("Teknik Informatika",{force:true});
        cy.get('.btn').contains("Submit").and("be.enabled");
    });
    it('Delete Mahasiswa List', () => {
        cy.visit("http://127.0.0.1:8000/mahasiswa");
        cy.get(':nth-child(2) > :nth-child(5) > form > .btn-danger').click();
    });
})