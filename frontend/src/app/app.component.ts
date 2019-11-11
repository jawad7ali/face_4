import { Component, OnInit } from '@angular/core';

import { Task } from './task';
import { TaskService } from './task.service';

@Component({
  selector: 'app-root',
  templateUrl: './app.component.html',
  styleUrls: ['./app.component.css']
})
export class AppComponent implements OnInit {
  tasks: Task[];
  error = '';
  success = '';

  task = new Task('', '0');

  constructor(private taskService: TaskService) {
  }

  ngOnInit() {
    this.getTasks();
  }

  getTasks(): void {
    this.taskService.getAll().subscribe(
      (res: Task[]) => {
        this.tasks = res;
      },
      (err) => {
        this.error = err;
      }
    );
  }

  addTask(f) {
    this.resetErrors();

    this.taskService.store(this.task)
      .subscribe(
        (res: Task[]) => {
          // Update the list of tasks
          this.tasks = res;

          // Inform the user
          this.success = 'Created successfully';

          // Reset the form
          f.reset();
        },
        (err) => this.error = err
      );
  }

  updateTask(title, description, id) {
    this.resetErrors();

    this.taskService.update({ title: title.value, description: description.value, id: +id })
      .subscribe(
        (res) => {
          this.tasks    = res;
          this.success = 'Updated successfully';
        },
        (err) => this.error = err
      );
  }

  deleteTask(id) {
    this.resetErrors();

    this.taskService.delete(+id)
      .subscribe(
        (res: Task[]) => {
          this.tasks = res;
          this.success = 'Deleted successfully';
        },
        (err) => this.error = err
      );
  }

  private resetErrors(){
    this.success = '';
    this.error   = '';
  }

}
