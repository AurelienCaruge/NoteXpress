<?php

namespace App\Test\Controller;

use App\Entity\Note;
use App\Repository\NoteRepository;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class NoteControllerTest extends WebTestCase
{
    private KernelBrowser $client;
    private NoteRepository $repository;
    private string $path = '/note/';

    protected function setUp(): void
    {
        $this->client = static::createClient();
        $this->repository = static::getContainer()->get('doctrine')->getRepository(Note::class);

        foreach ($this->repository->findAll() as $object) {
            $this->repository->remove($object, true);
        }
    }

    public function testIndex(): void
    {
        $crawler = $this->client->request('GET', $this->path);

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('Note index');

        // Use the $crawler to perform additional assertions e.g.
        // self::assertSame('Some text on the page', $crawler->filter('.p')->first());
    }

    public function testNew(): void
    {
        $originalNumObjectsInRepository = count($this->repository->findAll());

        $this->markTestIncomplete();
        $this->client->request('GET', sprintf('%snew', $this->path));

        self::assertResponseStatusCodeSame(200);

        $this->client->submitForm('Save', [
            'note[noteId]' => 'Testing',
            'note[userId]' => 'Testing',
            'note[categoryId]' => 'Testing',
            'note[title]' => 'Testing',
            'note[content]' => 'Testing',
        ]);

        self::assertResponseRedirects('/note/');

        self::assertSame($originalNumObjectsInRepository + 1, count($this->repository->findAll()));
    }

    public function testShow(): void
    {
        $this->markTestIncomplete();
        $fixture = new Note();
        $fixture->setNoteId('My Title');
        $fixture->setUserId('My Title');
        $fixture->setCategoryId('My Title');
        $fixture->setTitle('My Title');
        $fixture->setContent('My Title');

        $this->repository->save($fixture, true);

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('Note');

        // Use assertions to check that the properties are properly displayed.
    }

    public function testEdit(): void
    {
        $this->markTestIncomplete();
        $fixture = new Note();
        $fixture->setNoteId('My Title');
        $fixture->setUserId('My Title');
        $fixture->setCategoryId('My Title');
        $fixture->setTitle('My Title');
        $fixture->setContent('My Title');

        $this->repository->save($fixture, true);

        $this->client->request('GET', sprintf('%s%s/edit', $this->path, $fixture->getId()));

        $this->client->submitForm('Update', [
            'note[noteId]' => 'Something New',
            'note[userId]' => 'Something New',
            'note[categoryId]' => 'Something New',
            'note[title]' => 'Something New',
            'note[content]' => 'Something New',
        ]);

        self::assertResponseRedirects('/note/');

        $fixture = $this->repository->findAll();

        self::assertSame('Something New', $fixture[0]->getNoteId());
        self::assertSame('Something New', $fixture[0]->getUserId());
        self::assertSame('Something New', $fixture[0]->getCategoryId());
        self::assertSame('Something New', $fixture[0]->getTitle());
        self::assertSame('Something New', $fixture[0]->getContent());
    }

    public function testRemove(): void
    {
        $this->markTestIncomplete();

        $originalNumObjectsInRepository = count($this->repository->findAll());

        $fixture = new Note();
        $fixture->setNoteId('My Title');
        $fixture->setUserId('My Title');
        $fixture->setCategoryId('My Title');
        $fixture->setTitle('My Title');
        $fixture->setContent('My Title');

        $this->repository->save($fixture, true);

        self::assertSame($originalNumObjectsInRepository + 1, count($this->repository->findAll()));

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));
        $this->client->submitForm('Delete');

        self::assertSame($originalNumObjectsInRepository, count($this->repository->findAll()));
        self::assertResponseRedirects('/note/');
    }
}
