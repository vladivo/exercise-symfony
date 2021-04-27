import {Component, OnInit} from '@angular/core';
import {ActivatedRoute, Router} from "@angular/router";
import {EntityType} from "../../../../model/entity-component/entity-type";
import {EntityClientService} from "../../../../services/entity/entity-client.service";
import {Entity} from "../../../../model/entity/entity";
import {Location} from "@angular/common";

@Component({
  selector: 'app-entity-delete-page',
  templateUrl: './entity-delete-page.component.html',
})
export class EntityDeletePageComponent implements OnInit {
  public entity?: Entity;

  constructor(
    private readonly entityClient: EntityClientService,
    private readonly activatedRoute: ActivatedRoute,
    private readonly location: Location,
    private readonly router: Router,
  ) { }

  public ngOnInit(): void {
    const type: EntityType = this.activatedRoute.snapshot.params['type'];
    const id: string = this.activatedRoute.snapshot.params['id'];

    this.entityClient
      .load(type, id)
      .toPromise()
      .then((entity: Entity): void => { this.entity = entity });
  }

  public confirm(): void {
    this.entityClient
      .delete(this.entity!.type, this.entity!.id.toString())
      .toPromise()
      .then(this.navigateConfirm.bind(this));
  }

  public cancel(): void {
    this.navigateCancel();
  }

  private navigateConfirm(): void {
    this.router.navigate(['/entity', this.entity!.type])
  }

  private navigateCancel(): void {
    this.router.navigate(['/entity', this.entity!.type, this.entity!.id]);
  }
}
